<?php

namespace App\Http\Livewire;

use App\Models\CheckoutOption;
use Livewire\Component;
use App\Models\Plan;
use DB;
use Str;
use App\Models\DiscountCode;

class CheckoutComponent extends Component
{
    public $plan_id = 1;
    public $name;
    public $email;
    public $mobile_number;
    public $checkout_option = 4;
    public $discount_code = 'none';

    public function mount($plan_id, $checkout_option, $discount_code)
    {
        $this->plan_id = $plan_id;
        $this->checkout_option = $checkout_option;
        $this->discount_code = $discount_code;
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_number' => ['required', 'unique:users'],
            'discount_code' => ['required'],
            'checkout_option' => ['required']
        ];
    }


    public function updated($propertyName)
      {
        $this->validateOnly($propertyName);
    }

    public function generate_external_id($plan_id)
    {
        return Plan::find($plan_id)->plan.'_'.Str::random(8);
    }



    public function processPayment()
    {
        sleep(1);

        $validatedData = $this->validate();

        $external_id = $this->generate_external_id($this->plan_id);

        $temporary_username = app('App\Http\Controllers\UserController')->generate_temporary_username();
        
        app('App\Http\Controllers\UserController')->store($this->name, $temporary_username, $temporary_username, $external_id,$this->email, 5, $this->mobile_number, $this->discount_code, $this->checkout_option, $this->plan_id);

        try{
            DB::beginTransaction();
            if($this->checkout_option == '1')
            {
                $last_created_invoice_url = app('App\Http\Controllers\CheckoutController')->charge_user_account(
                $temporary_username, 
                $external_id,
                Plan::find($this->plan_id)->description,
                $this->email, 
                $this->mobile_number, 
                $this->name, 
                Plan::find($this->plan_id)->price-(Plan::find($this->plan_id)->price*CheckoutOption::find($this->checkout_option)->discount), 
                1,
            );
                
            }elseif($this->checkout_option == '2'){
                $last_created_invoice_url = app('App\Http\Controllers\CheckoutController')->charge_user_account(
                $temporary_username,
                $external_id,
                Plan::find($this->plan_id)->description,
                $this->email,
                $this->mobile_number,
                $this->name,
                Plan::find($this->plan_id)->price-(Plan::find($this->plan_id)->price*CheckoutOption::find($this->checkout_option)->discount),
                3,
            );
            }
            elseif($this->checkout_option == '3'){
                $last_created_invoice_url = app('App\Http\Controllers\CheckoutController')->charge_user_account(
                $temporary_username,
                $external_id,
                Plan::find($this->plan_id)->description,
                $this->email,
                $this->mobile_number,
                $this->name,
                Plan::find($this->plan_id)->price-(Plan::find($this->plan_id)->price*CheckoutOption::find($this->checkout_option)->discount),
                6,
            );
            }
            elseif($this->checkout_option == '4'){
                $last_created_invoice_url = app('App\Http\Controllers\CheckoutController')->charge_user_account(
                $temporary_username,
                $external_id,
                Plan::find($this->plan_id)->description,
                $this->email,
                $this->mobile_number,
                $this->name,
                Plan::find($this->plan_id)->price-(Plan::find($this->plan_id)->price*CheckoutOption::find($this->checkout_option)->discount),
                12,
             );
            }
             else{
                $last_created_invoice_url = app('App\Http\Controllers\CheckoutController')->charge_user_account(
                $temporary_username,
                $external_id,
                Plan::find($this->plan_id)->description,
                $this->email,
                $this->mobile_number,
                $this->name,
                Plan::find($this->plan_id)->price-(Plan::find($this->plan_id)->price*CheckoutOption::find($this->checkout_option)->discount),
                12,
             );
            }

            DB::commit();

            return redirect($last_created_invoice_url);
        }
        catch(\Exception $e)
        {   
            DB::rollback();

            ddd($e);

            return back()->with('error','Cannot complete your action.');
        }
    }

    // public function send_mail_to_user()
    // {
    //     $details =[
    //      'message' => CheckoutOption::find($this->checkout_option)->policy
    //     ];

    //     Mail::to(auth()->user()->email)->send(new SendThankyouMailToUser($details));
    // }

    public function render()
    {
        return view('livewire.checkout-component',[
            'plans' => Plan::where('id','!=','4')->get(),
            'checkout_options' => CheckoutOption::all(),
            'selected_plan' => Plan::find($this->plan_id),
            'selected_checkout_option' => CheckoutOption::find($this->checkout_option),
            'selected_discount_code' => DiscountCode::find($this->discount_code),
            'discount_codes' => DiscountCode::all(),
            'checkout_options' => CheckoutOption::all(),
        ]);
    }
}
