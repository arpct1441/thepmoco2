<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {        
     
       if($user->id === auth()->user()->id || auth()->user()->username === 'landley'){
           return view('users.edit', [
           'user' => $user,
           'roles' => Role::orderBy('role')->where('id','!=','5')->where('id','!=','10')->get(),
           ]);
       }else{
            abort(404);
       }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $attributes = request()->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
        'mobile_number' => ['required', Rule::unique('users', 'mobile_number')->ignore($user->id)],
        'password' => ['nullable'],
        'role_id' => ['nullable', Rule::exists('roles', 'id')],
        'status' => 'nullable',
        'avatar' => 'image',
        ]);

        if(isset($attributes['avatar']))
        {
            $attributes['avatar'] = request()->file('avatar')->store('avatars');
        }

        if(isset($attributes['password']))
        {
           $attributes['password'] = Hash::make($request->password);
           $attributes['email_verified_at'] = Carbon::now();
        }
        $user->update($attributes);

        return redirect('/profile/'.$user->username.'/edit')->with('success', 'Profile is successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
