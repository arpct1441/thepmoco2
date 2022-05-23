<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Property;
use App\Models\Representative;
use Illuminate\Support\Facades\Route;
use App\Mail\WelcomeMailToMember;
use App\Models\Role;
use Analytics;
use Spatie\Analytics\Period;
use \PDF;
use App\Models\Bill;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::get('/', [WebsiteController::class, 'index']);

Route::post('/subscribe', SubscribeController::class);

Route::post('/contact', ContactController::class);

Route::group(['middleware'=>['auth', 'verified']], function(){
    Route::prefix('/property/{property:uuid}')->group(function(){

    Route::get('units', [UnitController::class, 'index'])->name('units');
   
    Route::get('tenants', [TenantController::class, 'index'])->name('tenants');
    
    Route::get('owners', [OwnerController::class, 'index'])->name('owners');

     Route::get('bills', [BillController::class, 'index'])->name('bills');

     Route::get('collections', [CollectionController::class, 'index'])->name('collections');

     Route::get('concerns', [ConcernController::class, 'index'])->name('concerns');
    
    Route::get('team', [TeamController::class, 'index'])->name('team');

    Route::get('referrals', [ReferralController::class, 'index'])->name('referrals');

   Route::get('timestamps/{date}', TimestampController::class)->name('timestamps');
    
    //Route::get('tenants', [ContractController::class, 'index'])->name('contracts');

    Route::get('enrollees', [EnrolleeController::class, 'index'])->name('enrollees');

    Route::get('particulars', [ParticularController::class, 'index']);

    Route::get('/', [PropertyController::class, 'show'])->name('dashboard');    
    Route::get('edit', [PropertyController::class, 'edit']);
    Route::patch('update',[PropertyController::class, 'update']);
    Route::get('delete', [PropertyController::class, 'destroy']);

    //show contracts
    Route::get('/tenant_contract', [PropertyController::class, 'show_tenant_contract']);
    Route::get('/owner_contract', [PropertyController::class, 'show_owner_contract']);

    Route::get('roles', [PropertyRoleController::class, 'index']);

    Route::get('/team/{random_str}/create', [TeamController::class, 'create']);
    
    });

    Route::get('bill/{bills}', [CollectionController::class, 'create']);

    Route::get('unit/{unit}', [UnitController::class, 'show']);
    Route::get('unit/{unit}/contracts', UnitContractController::class);
    Route::get('unit/{unit}/deed_of_sales', UnitDeedOfSalesController::class);
    Route::get('unit/{unit}/bills', UnitBillController::class);
    Route::get('unit/{batch_no}/create', [UnitController::class, 'create']);
    Route::post('unit/{batch_no}/store', [UnitController::class, 'store']);
    //edit multiple units
    Route::get('units/{batch_no}/edit', [UnitController::class, 'bulk_edit']);
    //update multiple units
    Route::patch('units/{batch_no}/update', [UnitController::class, 'bulk_update']);

    //edit single unit
    Route::get('unit/{unit}/edit', [UnitController::class, 'edit']);
    //update single unit
    Route::patch('unit/{unit}/update', [UnitController::class, 'update']);

    Route::delete('unit/{uuid:uuid}/delete', [UnitController::class, 'destroy']);
    Route::patch('unit/{batch_no}/update', [UnitController::class, 'update']);

    //edit an individual unit


    Route::post('building/{random_str}/store',[BuildingController::class, 'store']);

    Route::get('tenant/{tenant:uuid}', [TenantController::class, 'show']);
    Route::get('tenant/{tenant}/contracts', [TenantContractController::class, 'index']);
    //'Route::get('tenant/{tenant}/unit/{unit}/contract/units', [TenantContractController::class, 'units']);
    Route::get('tenant/{tenant}/unit/{unit}/edit', [TenantContractController::class, 'create']);
//     Route::get('tenant/{tenant}/unit/{unit}/contract/create', [TenantContractController::class, 'create']);
    Route::get('tenant/{tenant}/bills', [TenantBillController::class, 'index']);
    Route::get('tenant/{tenant}/bill/create', [TenantBillController::class, 'store']);
    Route::get('tenant/{tenant}/bill/export', [TenantBillController::class, 'export']);
    Route::get('tenant/{tenant}/collections', [TenantCollectionController::class, 'index']);
    Route::get('tenant/{tenant}/collection/store', [TenantCollectionController::class, 'store']);
    Route::get('tenant/{tenant}/ar/{ar}/export', [TenantCollectionController::class, 'export']);
    Route::get('tenant/{tenant}/concerns', TenantConcernController::class);
    Route::get('tenant/{tenant}/edit', [TenantController::class, 'edit']);
    Route::get('tenant/{uuid}/delete', [TenantController::class, 'destroy']);
    Route::patch('tenant/{tenant}/update', [TenantController::class, 'update']);
    Route::get('owner/{owner}', [OwnerController::class, 'show']);
    Route::get('owner/{owner}/deed_of_sales', OwnerDeedOfSalesController::class);
    Route::get('owner/{owner}/enrollees', OwnerEnrolleeController::class);
    Route::get('owner/{owner}/bills', OwnerBillController::class);
    Route::get('owner/{owner}/collections', OwnerCollectionController::class);
    Route::get('owner/{owner}/edit', [OwnerController::class, 'edit']);
  

    Route::get('properties', [PropertyController::class, 'index'])->name('properties');
    Route::get('property/{random_str}/create/', [PropertyController::class, 'create']);
    Route::post('property/{random_str}/store', [PropertyController::class, 'store']);

    Route::get('team/{random_str}/create', [TeamController::class, 'create']);
    Route::get('team/{user:username}/edit', [TeamController::class, 'edit']);
    Route::post('team/{random_str}/store', [TeamController::class, 'store']);
    Route::patch('team/{user:username}/update', [TeamController::class, 'update']);
    Route::delete('team/{id:id}/delete', [TeamController::class, 'destroy']);
    Route::patch('team/{random_str}/save', [TeamController::class, 'save']);

    //Creating tenant contract
    //1
    Route::get('unit/{unit}/tenant/{random_str}/new_create', NewTenantController::class);
    Route::get('unit/{unit}/tenant/{random_str}/old_create', [OldTenantController::class, 'index']);
    Route::get('tenant_sheet/export', [OldTenantController::class, 'export']);
    Route::post('unit/{unit}/tenant/{random_str}/store', [TenantController::class, 'store']);

    //2
    Route::get('unit/{unit}/tenant/{tenant}/guardian/{random_str}/create', [GuardianController::class, 'create']);
    Route::post('tenant/{tenant}/guardian/store', [GuardianController::class, 'store']);
    Route::delete('guardian/{id:id}/delete', [GuardianController::class, 'destroy']);
     Route::get('guardian/{id:id}/delete', [GuardianController::class, 'destroy']);
    //3
    Route::get('unit/{unit}/tenant/{tenant}/reference/{random_str}/create', [ReferenceController::class, 'create']);
    Route::post('tenant/{tenant}/reference/store', [ReferenceController::class, 'store']);
    Route::delete('reference/{id:id}/delete', [ReferenceController::class, 'destroy']);
    Route::get('reference/{id:id}/delete', [ReferenceController::class, 'destroy']);
    //4
    Route::get('unit/{unit}/tenant/{tenant}/contract/{random_str}/create', [ContractController::class, 'create']);
    Route::post('unit/{unit}/tenant/{tenant}/contract/{random_str}/store', [ContractController::class, 'store']);
    Route::get('/contract/{contract}/edit', [ContractController::class, 'edit']);
    Route::get('/contract/{contract}/preview', [ContractController::class, 'preview']);
    Route::patch('/contract/{contract}/update', [ContractController::class, 'update']);
    //5
    Route::get('unit/{unit}/tenant/{tenant}/contract/{contract}/bill/{random_str}/create', [BillController::class, 'create']);
    Route::post('unit/{unit}/tenant/{tenant}/contract/{contract}/bill/{random_str}/store', [BillController::class,'store']);
    Route::delete('bill/{id:id}/delete', [BillController::class, 'destroy']);

    Route::post('bill/{uuid:uuid}/store/{bill_count}/express', PropertyBillExpressController::class);
     
    Route::post('bill/{uuid:uuid}/store/{bill_count}/customized', [PropertyBillCustomizedController::class, 'store']);

    Route::get('bill/{uuid:uuid}/customized/batch/{batch_no}', [PropertyBillCustomizedController::class, 'edit']);

    Route::patch('bill/{uuid:uuid}/customized/batch/{batch_no}', [PropertyBillCustomizedController::class, 'update']);
    //4
 
    //Creating owner contract
    //1
    Route::get('unit/{unit}/owner/{random_str}/create', [OwnerController::class, 'create']);
    Route::post('unit/{unit}/owner/{random_str}/store', [OwnerController::class, 'store']);
    //2
    Route::get('unit/{unit}/owner/{owner}/sale/{random_str}/create', [DeedOfSaleController::class,'create']);
    Route::post('unit/{unit}/owner/{owner}/sale/{random_str}/store',[DeedOfSaleController::class,'store']);
    //3
    Route::get('unit/{unit}/owner/{owner}/representative/{random_str}/create', [RepresentativeController::class,'create']);
    Route::post('unit/{unit}/owner/{owner}/representative/{random_str}/store',[RepresentativeController::class,'store']);
    Route::delete('representative/{id:id}/delete', [RepresentativeController::class, 'destroy']);
    ///4
    Route::get('unit/{unit}/owner/{owner}/bank/{random_str}/create', [BankController::class, 'create']);
    Route::post('unit/{unit}/owner/{owner}/bank/{random_str}/store', [BankController::class,'store']);
    Route::delete('bank/{id:id}/delete', [BankController::class, 'destroy']);
    Route::delete('bank/{id:id}/delete', [BankController::class, 'destroy']);
    //4
    Route::get('unit/{unit}/owner/{owner}/enrollee/{random_str}/create', [EnrolleeController::class, 'create']);
    Route::post('unit/{unit}/owner/{owner}/enrollee/{random_str}/store', [EnrolleeController::class, 'store']);
    //3
    
    Route::get('unit/{unit}/tenant/{tenant}/contract/{contract}/bill/{random_str}/create', [BillController::class,
    'create']);
    Route::post('unit/{unit}/tenant/{tenant}/contract/{contract}/bill/{random_str}/store',
    [BillController::class,'store']);
    Route::delete('bill/{id:id}/delete', [BillController::class, 'destroy']);

    Route::get('/profile/{user}/edit',[UserController::class, 'edit'])->name('profile');
    Route::patch('/profile/{user}/update',[UserController::class, 'update']);

    Route::get('/profile/{username:username}/point',[PointController::class, 'index'])->name('point');

    Route::post('/particular/{random_str}/store', [ParticularController::class, 'store']);
    Route::get('/particular/{random_str}/create', [ParticularController::class, 'create']);

    Route::get('/particular/{random_str}/store', [ParticularController::class, 'store']);

    Route::get('/documentation', [DocumentationController::class, 'index'])->name('documentation');

    Route::get('/contract/{contract}/moveout', MoveoutContractController::class);
    
    Route::get('/contract/{contract}/moveout/bills', MoveoutContractBillController::class);

   Route::get('/contract/{contract}/renew', RenewContractController::class);

    Route::get('/contract/{contract}/export', ContractExportController::class);

    Route::get('/contract/{contract}/signed_contract', ExportSignedContractController::class);

    Route::get('/contract/{contract}/transfer', TransferContractController::class);

    Route::get('/tenant/{tenant}/new_contract', NewContractController::class);

   Route::get('data', function(){
        //retrieve visitors and pageview data for the current day and the last seven days
        //$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::months(2));

        //retrieve visitors and pageviews since the 6 months ago
        //$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::months(6));

        //retrieve sessions and pageviews with yearMonth dimension since 1 year ago
        $analyticsData = Analytics::performQuery(
        Period::years(1),
        'ga:sessions',
        [
        'metrics' => 'ga:sessions, ga:pageviews',
        'dimensions' => 'ga:yearMonth'
        ]
        );
        dd($analyticsData);
   });

});
