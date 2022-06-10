<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use Illuminate\Support\Str;
use App\Models\Property;
use Carbon\Carbon;
use Session;
use Illuminate\Validation\Rule;
use App\Models\Contract;
use App\Models\Tenant;
use DB;
use App\Models\Point;

class PropertyBillExpressController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $property_uuid, $bill_count)
    {
        $attributes = request()->validate([
            'particular_id' => ['required', Rule::exists('particulars', 'id')],
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'due_date' => 'nullable|date|after:start',
        ]);
    
        $tenant_uuid = Contract::where('property_uuid', Session::get('property'))
        ->where('contracts.status','active')
        ->pluck('tenant_uuid');

        $bill_no = Property::find(Session::get('property'))->bills->max('bill_no')+1;

        try{

            DB::beginTransaction();
            
            for($i=0; $i<$bill_count; $i++)
            { 
                $unit_uuid=Contract::where('property_uuid', Session::get('property')) ->
                where('contracts.status','active')
                ->where('tenant_uuid', $tenant_uuid[$i])
                ->pluck('unit_uuid');

                $reference_no = Tenant::find($tenant_uuid[$i]);

                $rent = Contract::where('property_uuid', Session::get('property'))
                ->where('contracts.status','active')
                ->where('tenant_uuid', $tenant_uuid[$i])
                ->pluck('rent');

                $attributes['unit_uuid']= $unit_uuid[0];
                $attributes['tenant_uuid'] = $tenant_uuid[$i];
                if($request->particular_id == 1)
                {
                    $attributes['bill'] = $rent[0];
                }
                $attributes['bill_no'] = $bill_no++;
                $attributes['reference_no'] = $reference_no->bill_reference_no;
                $attributes['user_id'] = auth()->user()->id;
                $attributes['due_date'] = Carbon::parse($request->start)->addDays(7);
                $attributes['property_uuid'] = Session::get('property');

                Bill::create($attributes);

                }

                app('App\Http\Controllers\PointController')->store(Session::get('property'), $bill_count, 3);

                DB::commit();

                return back()->with('success', $i.' bills have been posted.');

            }catch(\Exception $e)
            {   
                DB::rollback();
                return back('error')->with('success', 'Cannot perform your action.');
            }
    }
}
