<?php

namespace App\Http\Controllers;

use App\Models\AcknowledgementReceipt;
use App\Mail\SendPaymentToTenant;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Collection;
use App\Models\Property;
use App\Models\User;
use Session;
use DB;
use App\Models\Bill;
use \PDF;
use Carbon\Carbon;

class TenantCollectionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Property $property, Tenant $tenant)
    {
        return view('tenants.collections.index',[
         'tenant' => Tenant::find($tenant->uuid),
         'collections' => Tenant::find($tenant->uuid)->acknowledgementreceipts
        ]);
    }

    public function edit(Property $property, Tenant $tenant, $batch_no)
    {
      $collections = Bill::where('tenant_uuid', $tenant->uuid)
      ->where('batch_no', $batch_no)
      ->get();

      return view('tenants.collections.edit',[
         'collections' => $collections,
         'tenant' => $tenant,
         'batch_no' => $batch_no
      ]);
    }

    public function store(Request $request, Property $property, Tenant $tenant, $batch_no)
    {     
         $attributes = request()->validate([
            'collection' => 'required|integer|min:1',
         ]);

         try {

            DB::beginTransaction();

            $collection = $request->collection;
            
            $unpaid_bills_id = Bill::where('reference_no', $tenant->bill_reference_no)
            ->where('status','unpaid')
            ->orderBy('bill_no')
            ->pluck('id');

            $unpaid_bills_bill = Bill::where('reference_no', $tenant->bill_reference_no)
            ->where('status','unpaid')
            ->orderBy('bill_no')
            ->pluck('bill');

            if($collection>=$unpaid_bills_bill[0])
            {
                for($i=0; $i<$unpaid_bills_id->count(); $i++)
                { 
                   do{
                        $bill = Bill::find($unpaid_bills_id[$i]);
                        $bill->status = 'paid';
                        $bill->save();
                
                        $ar_no = Property::find(Session::get('property'))->collections->max('ar_no');

                        $attributes['tenant_uuid']= $tenant->uuid;
                        $attributes['property_uuid'] = Session::get('property');
                        $attributes['user_id'] = auth()->user()->id;
                        $attributes['ar_no'] = $ar_no+1;
                        $attributes['bill_id'] = $unpaid_bills_id[$i];
                        $attributes['bill_reference_no']= $tenant->bill_reference_no;
                        $attributes['form']= $request->form;

                        Collection::create($attributes);

                        $collection -= $unpaid_bills_bill[$i];

                   }while($collection>=$unpaid_bills_bill[$i]);
                }

                DB::commit();

                return back()->with('success','Collections has been saved.');
            }

            return back()->with('error','The collection is less than the bill.');

         }
         catch(\Exception $e)
         {
             ddd($e);
            return back()->with('error','Cannot perform the action. Please try again.');
         }
    }

     public function export(Property $property, Tenant $tenant, AcknowledgementReceipt $ar)
     {          
         $balance = app('App\Http\Controllers\TenantBillController')->get_tenant_balance($ar->tenant_uuid);
   
         $property = Property::find(Session::get('property'));

         $data = [
            'created_at' => $ar->created_at,
            'reference_no' => $tenant->bill_reference_no,
            'tenant' => Tenant::find($ar->tenant_uuid)->tenant,
            'mode_of_payment' => $ar->mode_of_payment,
            'user' => User::find($ar->user_id)->name,
            'role' => User::find($ar->user_id)->role->role,
            'ar_no' => $ar->ar_no,
            'amount' => $ar->amount,
            'cheque_no' => $ar->cheque_no,
            'bank' => $ar->bank,
            'date_deposited' => $ar->date_deposited,
            'collections' => Collection::where('tenant_uuid',$ar->tenant_uuid)->where('batch_no',
            $ar->collection_batch_no)->orderBy('ar_no','asc')->get(),
            'balance' => $balance
         ];

        $pdf = PDF::loadView('tenants.collections.export', $data);

               $pdf->output();
               $canvas = $pdf->getDomPDF()->getCanvas();

               $height = $canvas->get_height();
               $width = $canvas->get_width();

               $canvas->set_opacity(.2,"Multiply");

               $canvas->set_opacity(.2);

               $canvas->page_text($width/5, $height/2, $property->property, null,
               55, array(0,0,0),2,2,-30);

        return $pdf->download($tenant->tenant.'-ar.pdf');
     }

     public function get_selected_bills_count($batch_no)
     {
        return Collection::where('property_uuid', Session::get('property'))
         ->where('batch_no', $batch_no)
         ->where('is_posted', false)
         ->max('id');
     }

     public function update(Request $request, Property $property, Tenant $tenant, $batch_no)
     {
         $ar_no = app('App\Http\Controllers\AcknowledgementReceiptController')->get_latest_ar(Session::get('property'));

         $counter = $this->get_selected_bills_count($batch_no);
      
         for($i=0; $i<=$counter; $i++)
         {
            $collection = (int) $request->input("collection_amount_".$i);

            $form = $request->form;

            $bill_id = $request->input("bill_id_".$i);

            $total_amount_due = app('App\Http\Controllers\TenantBillController')->get_bill_balance($bill_id);

            app('App\Http\Controllers\CollectionController')->update($ar_no, $bill_id, $collection, $form,);

            if(($total_amount_due) <= $collection)
            {
                app('App\Http\Controllers\BillController')->update_bill_amount_due($bill_id, 'paid');

                app('App\Http\Controllers\BillController')->update_bill_initial_payment($bill_id , $collection);
            }
            else
            {
                app('App\Http\Controllers\BillController')->update_bill_amount_due($bill_id, 'partially_paid');

                app('App\Http\Controllers\BillController')->update_bill_initial_payment($bill_id, $collection);
            }
         }

         app('App\Http\Controllers\AcknowledgementReceiptController')
         ->store(
                  $tenant->uuid,
                  Collection::where('ar_no', $ar_no)->where('batch_no', $batch_no)->sum('collection'),
                  Session::get('property'),
                  auth()->user()->id,
                  $ar_no,
                  $request->form,
                  $batch_no,
                  $request->check_no,
                  $request->bank,
                  $request->date_deposited,
                  $request->created_at,
         );

         app('App\Http\Controllers\PointController')->store(Session::get('property'), auth()->user()->id, Collection::where('ar_no', $ar_no)->where('batch_no', $batch_no)->count(), 6);

          $data = [
            'tenant' => $tenant->tenant,
            'ar_no' => $ar_no,
            'form' => $request->form,
            'payment_made' => $request->created_at,
            'user' => User::find(auth()->user()->id)->name,
            'role' => User::find(auth()->user()->id)->role->role,
            'collections' => Collection::where('tenant_uuid',$tenant->uuid)->where('batch_no', $batch_no)->get()
          ];

          if($tenant->email){
            Mail::to($tenant->email)->send(new SendPaymentToTenant($data));
          }
   
         return redirect('/property/'.Session::get('property').'/tenant/'.$tenant->uuid.'/bills')->with('success', 'Payment is successfully created.');
     }

     public function destroy(Property $property, Tenant $tenant, $batch_no)
     {
         Collection::where('tenant_uuid', $tenant->uuid)
         ->where('batch_no', $batch_no)
         ->delete();

         Bill::where('tenant_uuid', $tenant->uuid)
         ->where('batch_no', $batch_no)
         ->update([
            'batch_no' => null
         ]);

         return redirect('/property/'.Session::get('property').'/tenant/'.$tenant->uuid.'/bills');
     }
}
