<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use App\Models\Unit;
use App\Models\Tenant;
use Session;
use App\Models\References;

use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Unit $unit, Tenant $tenant)
    {
        Session::flash('success', 'You have skipped adding guardians.');

        $references = Tenant::find($tenant->uuid)->references;

         return view('references.create',[
         'unit' => $unit,
         'tenant' => $tenant,
         'references' => Tenant::find($tenant->uuid)->references,
         ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Unit $unit, Tenant $tenant)
    {
        $reference_attributes = request()->validate([
        'reference' => 'required',
        'email' => ['required', 'string', 'email', 'max:255'],
        'mobile_number' => 'required',
        'relationship_id' => 'required',
        ]);

        $reference_attributes['tenant_uuid'] = $tenant->uuid;

        Reference::create($reference_attributes);

        return back()->with('success', 'Reference has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reference  $reference
     * @return \Illuminate\Http\Response
     */
    public function show(Reference $reference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reference  $reference
     * @return \Illuminate\Http\Response
     */
    public function edit(Reference $reference)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reference  $reference
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reference $reference)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reference  $reference
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reference = Reference::where('id', $id);
        $reference->delete();

        return back()->with('success', 'A reference has been removed.');
    }
}
