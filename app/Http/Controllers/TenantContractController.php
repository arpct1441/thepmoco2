<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Property;
use Session;

class TenantContractController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Tenant $tenant)
{
        return view('tenants.contracts.index',[
            'tenant' => Tenant::find($tenant->uuid),
            'contracts' => Tenant::find($tenant->uuid)->contracts,
            'units' => Property::find(Session::get('property'))->units()->where('status_id', '1')->get(),
        ]);
    }

    public function edit(Request $request, Tenant $tenant, Unit $unit)
    {
        return redirect('/tenant/'.$tenant->uuid.'/unit/'.$unit->uuid.'/contract/create');
    }

    public function create(Request $request, Tenant $tenant, Unit $unit)
    {
    return view('contracts.create', [
            'unit' => $unit,
            'tenant' => $tenant
        ]);
    }



}
