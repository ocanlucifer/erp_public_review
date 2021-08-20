<?php

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

Route::get('/', function () {
    return redirect('/home');
    //return view('auth.login');
});

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/autocomplete/divisi', 'AutocompleteController@divisi')->name('autocomplete.divisi');
Route::post('/autocomplete/country', 'AutocompleteController@country')->name('autocomplete.country');
Route::post('/autocomplete/currency', 'AutocompleteController@currency')->name('autocomplete.currency');
Route::post('/autocomplete/perusahaan', 'AutocompleteController@perusahaan')->name('autocomplete.perusahaan');
Route::post('/autocomplete/satuan', 'AutocompleteController@satuan')->name('autocomplete.satuan');
Route::post('/autocomplete/quotation', 'AutocompleteController@quotation')->name('autocomplete.quotation');
Route::post('/autocomplete/quotation2', 'AutocompleteController@quotation2')->name('autocomplete.quotation2');
Route::post('/autocomplete/customer', 'AutocompleteController@customer')->name('autocomplete.customer');
Route::post('/autocomplete/style', 'AutocompleteController@style')->name('autocomplete.style');
Route::post('/autocomplete/brand', 'AutocompleteController@brand')->name('autocomplete.brand');
Route::post('/autocomplete/sample_type', 'AutocompleteController@sample_type')->name('autocomplete.sample_type');
Route::post('/autocomplete/garment_type', 'AutocompleteController@garment_type')->name('autocomplete.garment_type');
Route::post('/autocomplete/garment_type2', 'AutocompleteController@garment_type2')->name('autocomplete.garment_type2');
Route::post('/autocomplete/color', 'AutocompleteController@color')->name('autocomplete.color');
Route::post('/autocomplete/colorInTable', 'AutocompleteController@colorInTable')->name('autocomplete.colorInTable');
Route::post('/autocomplete/color_form', 'AutocompleteController@color_form')->name('autocomplete.color_form');
Route::post('/autocomplete/size', 'AutocompleteController@size')->name('autocomplete.size');
Route::post('/autocomplete/sizeInTable', 'AutocompleteController@sizeInTable')->name('autocomplete.sizeInTable');
Route::post('/autocomplete/style', 'AutocompleteController@style')->name('autocomplete.style');
Route::post('/autocomplete/buyer', 'AutocompleteController@buyer')->name('autocomplete.buyer');
Route::post('/autocomplete/fabricconst', 'AutocompleteController@fabricconst')->name('autocomplete.fabricconst');
Route::post('/autocomplete/fabriccomp', 'AutocompleteController@fabriccomp')->name('autocomplete.fabriccomp');
Route::post('/autocomplete/fabricconst_edit', 'AutocompleteController@fabricconst_edit')->name('autocomplete.fabricconst_edit');
Route::post('/autocomplete/fabriccomp_edit', 'AutocompleteController@fabriccomp_edit')->name('autocomplete.fabriccomp_edit');
Route::post('/autocomplete/d_fabricconst', 'AutocompleteController@d_fabricconst')->name('autocomplete.d_fabricconst');
Route::post('/autocomplete/d_fabriccomp', 'AutocompleteController@d_fabriccomp')->name('autocomplete.d_fabriccomp');
Route::post('/autocomplete/ed_fabricconst', 'AutocompleteController@ed_fabricconst')->name('autocomplete.ed_fabricconst');
Route::post('/autocomplete/ed_fabriccomp', 'AutocompleteController@ed_fabriccomp')->name('autocomplete.ed_fabriccomp');
Route::post('/autocomplete/mcp', 'AutocompleteController@mcp')->name('autocomplete.mcp');
Route::post('/autocomplete/supplier', 'AutocompleteController@supplier')->name('autocomplete.supplier');
Route::post('/autocomplete/supplier_edit', 'AutocompleteController@supplier_edit')->name('autocomplete.supplier_edit');

Route::post('/autocomplete/wUnitInTable', 'AutocompleteController@wUnitInTable')->name('autocomplete.wUnitInTable');
Route::post('/autocomplete/UnitInTable', 'AutocompleteController@UnitInTable')->name('autocomplete.UnitInTable');
Route::post('/autocomplete/unit', 'AutocompleteController@unit')->name('autocomplete.unit');


Route::get('/manage_user', 'ManageUserController@index');
Route::get('/manage_user/reset_password/{id}', 'ManageUserController@resetPassword');
Route::get('/manage_user/delete/{id}', 'ManageUserController@delete');
// Route::get('/manage_user/edit/{id}', function () {
//     return view('manage_user.edit_form');
// });
Route::post('/manage_user/updateRole', 'ManageUserController@updateRole');

Route::get('/brand', 'BrandController@index');
Route::get('/brand/delete/{id}', 'BrandController@delete');
Route::post('/brand/update', 'BrandController@update');
Route::post('/brand/new', 'BrandController@new');
Route::get('/brand/editform', 'BrandController@editform');

Route::get('/countries', 'CountriesController@index');
Route::get('/countries/delete/{id}', 'CountriesController@delete');
Route::post('/countries/update', 'CountriesController@update');
Route::post('/countries/new', 'CountriesController@new');
Route::get('/countries/editform', 'CountriesController@editform');

Route::get('/divisi', 'DivisiController@index');
Route::get('/divisi/delete/{id}', 'DivisiController@delete');
Route::post('/divisi/update', 'DivisiController@update');
Route::post('/divisi/new', 'DivisiController@new');

Route::get('/perusahaan', 'PerusahaanController@index');
Route::get('/perusahaan/delete/{id}', 'PerusahaanController@delete');
Route::post('/perusahaan/update', 'PerusahaanController@update');
Route::post('/perusahaan/new', 'PerusahaanController@new');

Route::get('/customer', 'CustomerController@index');
Route::get('/customer/delete/{id}', 'CustomerController@delete');
Route::get('/customer/new', 'CustomerController@new');
Route::get('/customer/edit/{id}', 'CustomerController@edit');
Route::post('/customer/update', 'CustomerController@update');
Route::post('/customer/save', 'CustomerController@save');

Route::get('/supplier', 'SupplierController@index');
Route::get('/supplier/delete/{id}', 'SupplierController@delete');
Route::get('/supplier/new', 'SupplierController@new');
Route::get('/supplier/edit/{id}', 'SupplierController@edit');
Route::post('/supplier/update', 'SupplierController@update');
Route::post('/supplier/save', 'SupplierController@save');

Route::get('/unit', 'UnitController@index');
Route::get('/unit/delete/{id}', 'UnitController@delete');
Route::post('/unit/update', 'UnitController@update');
Route::post('/unit/new', 'UnitController@new');
Route::post('/unit/getbyajax', 'UnitController@getByAjax');
Route::get('/unit/editform', 'UnitController@editform');

Route::get('/size', 'SizeController@index');
Route::get('/size/delete/{id}', 'SizeController@delete');
Route::post('/size/update', 'SizeController@update');
Route::post('/size/new', 'SizeController@new');
Route::get('/size/editform', 'SizeController@editform');

Route::get('/style', 'StyleController@index');
Route::get('/style/delete/{id}', 'StyleController@delete');
Route::post('/style/update', 'StyleController@update');
Route::post('/style/new', 'StyleController@new');
Route::get('/style/editform', 'StyleController@editform');

Route::get('/style_sample', 'StyleSampleController@index');
Route::get('/style_sample/delete/{id}', 'StyleSampleController@delete');
Route::post('/style_sample/update', 'StyleSampleController@update');
Route::post('/style_sample/new', 'StyleSampleController@new');
Route::get('/style_sample/editform', 'StyleSampleController@editform');

Route::get('/color', 'ColorController@index');
Route::get('/color/delete/{id}', 'ColorController@delete');
Route::post('/color/update', 'ColorController@update');
Route::post('/color/new', 'ColorController@new');
Route::get('/color/editform', 'ColorController@editform');

Route::get('/ppn', 'PpnController@index');
Route::get('/ppn/delete/{id}', 'PpnController@delete');
Route::post('/ppn/update', 'PpnController@update');
Route::post('/ppn/new', 'PpnController@new');
Route::get('/ppn/editform', 'PpnController@editform');

Route::get('/tipe_bc', 'TipeBCController@index');
Route::get('/tipe_bc/delete/{id}', 'TipeBCController@delete');
Route::post('/tipe_bc/update', 'TipeBCController@update');
Route::post('/tipe_bc/new', 'TipeBCController@new');
Route::get('/tipe_bc/editform', 'TipeBCController@editform');

Route::get('/material', 'MaterialController@index');
Route::get('/material/delete/{id}', 'MaterialController@delete');
Route::get('/material/new', 'MaterialController@new');
Route::get('/material/edit/{id}', 'MaterialController@edit');
Route::post('/material/update', 'MaterialController@update');
Route::post('/material/save', 'MaterialController@save');

Route::get('/currencies', 'CurrenciesController@index');
Route::get('/currencies/delete/{id}', 'CurrenciesController@delete');
Route::post('/currencies/update', 'CurrenciesController@update');
Route::post('/currencies/new', 'CurrenciesController@new');

Route::get('/fabric_const', 'fabricconstController@index');
Route::get('/fabric_const/delete/{id}', 'fabricconstController@delete');
Route::post('/fabric_const/update', 'fabricconstController@update');
Route::post('/fabric_const/new', 'fabricconstController@new');

Route::get('/fabric_comp', 'fabriccompController@index');
Route::get('/fabric_comp/delete/{id}', 'fabriccompController@delete');
Route::post('/fabric_comp/update', 'fabriccompController@update');
Route::post('/fabric_comp/new', 'fabriccompController@new');

Route::get('/mcp', 'McpController@index');
Route::get('/mcp/confirm/{id}/{state}', 'McpController@confirm');
Route::get('/mcp/edit/{id}', 'McpController@edit');
Route::get('/mcp/edit_ws/{id_mcpwsm}/{id_mcp}', 'McpController@editws');
Route::get('/mcp/edit_mcpt/{id_mcpt}/{id_mcp}', 'McpController@editmcpt');
Route::get('/mcp/edit_mcpd/{id_mcpd}/{id_mcp}/{id_mcpwsm}', 'McpController@editmcpd');
Route::get('/mcp/edit_mcpi/{id_mcpi}/{id_mcp}/{id_mcpwsm}', 'McpController@editmcpi');
Route::get('/mcp/delete/{id}', 'McpController@delete');
Route::get('/mcp/delete_ws/{id}', 'McpController@deletews');
Route::get('/mcp/delete_mcpt/{id}', 'McpController@deletemcpt');
Route::get('/mcp/delete_mcpd/{id}', 'McpController@deletemcpd');
Route::get('/mcp/delete_mcpi/{id}', 'McpController@deletemcpi');
Route::get('/mcp/detail/{id}', 'McpController@detail');
Route::get('/mcp/show_detail/{id_mcpd}/{id_mcp}/{id_mcpwsm}', 'McpController@showdetail');

// Route::get('/mcp/print_rekkonsdom/{mcp_id}', 'McpController@print_rekkonsdom');
Route::get('/mcp/print_mcp/{mcp_id}', 'McpController@print_mcp');
Route::get('/mcp/print_wsm/{mcp_id}/{mcpwsm_id}', 'McpController@print_wsm');
Route::get('/mcp/print_ws/{mcp_id}/{mcpwsm_id}/{mcpt_id}', 'McpController@print_ws');
Route::get('/mcp/print_rekpiping/{mcp_id}', 'McpController@print_rekpiping');
Route::get('/mcp/print_detail/{filename}', 'McpController@print_detmcp');
Route::get('/tes_mpdf', 'McpController@tes');
// Route::get('/tes_mpdf', 'McpController@tes');

Route::post('/mcp/geteditsize', 'McpController@edit_getsize');
Route::post('/mcp/getsize', 'McpController@detail_getsize');
Route::post('/mcp/create', 'McpController@create');
Route::post('/mcp/update', 'McpController@update');
Route::post('/mcp/create_ws', 'McpController@createws');
Route::post('/mcp/create_type', 'McpController@createtype');
Route::post('/mcp/create_detail', 'McpController@createdetail_ma')->name('mcp.createdetail_ma');
Route::post('/mcp/create_detail_pi', 'McpController@createdetail_pi')->name('mcp.createdetail_pi');
Route::post('/mcp/update_ws', 'McpController@updatews');
Route::post('/mcp/update_mcpt', 'McpController@updatemcpt');
Route::post('/mcp/update_mcpd', 'McpController@updatemcpd_ma')->name('mcp.updatedetail_ma');
Route::post('/mcp/update_mcpi', 'McpController@updatemcpd_pi')->name('mcp.updatedetail_pi');

Route::get('/markercal', 'MarkercalController@index');
Route::post('/markercal/create', 'MarkercalController@create');
Route::post('/markercal/edit/{id}', 'MarkercalController@edit');
Route::post('/markercal/update', 'MarkercalController@update');
Route::get('/markercal/delete/{id}', 'MarkercalController@delete');
Route::post('/markercal/confirm/{id}', 'MarkercalController@confirm');
Route::post('/markercal/unconfirm/{id}', 'MarkercalController@unconfirm');
Route::get('/markercal/print/{id}', 'MarkercalController@print');
Route::get('/mcd/{id}', 'MarkercalController@mcd');
Route::post('/mcd/create', 'MarkercalController@mcd_create');
Route::post('/mcd/edit/{id}', 'MarkercalController@mcd_edit');
Route::post('/mcd/update', 'MarkercalController@mcd_update');
Route::get('/mcd/delete/{id}', 'MarkercalController@mcd_delete');
Route::get('/mcd/confirm/{id}', 'MarkercalController@mcd_confirm');
Route::get('/mcd/unconfirm/{id}', 'MarkercalController@mcd_unconfirm');
Route::post('/mcd/get_markercal_g', 'MarkercalController@get_mcg');
Route::get('/mcd/print/{id}', 'MarkercalController@mcd_print');
Route::post('/mcg/create', 'MarkercalController@createG');
Route::post('/mcg/edit', 'MarkercalController@editG');
Route::post('/mcg/update', 'MarkercalController@updateG');
Route::get('/mcg/delete/{id}', 'MarkercalController@deleteG');


Route::get('/marker', 'MarkerController@index');
Route::get('/marker/delete/{id}', 'MarkerController@delete');
Route::post('/marker/update', 'MarkerController@update');
Route::post('/marker/new', 'MarkerController@new');

Route::get('/promark', 'ProductionMarkerController@index');
Route::get('/promark/delete/{id}', 'ProductionMarkerController@delete');
Route::post('/promark/update', 'ProductionMarkerController@update');
Route::post('/promark/new', 'ProductionMarkerController@new');

Route::get('/markerfabric', 'MarkerfabricController@index');
Route::get('/markerfabric/{id}', 'MarkerfabricController@getData');
Route::get('/markerfabric/delete/{id}', 'MarkerfabricController@delete');
Route::post('/markerfabric/update', 'MarkerfabricController@update');
Route::post('/markerfabric/new', 'MarkerfabricController@new');
Route::post('/markerfabric/getcomp/', 'MarkerfabricController@getFabricComp');
Route::get('/markerfabric/print/{id}', 'MarkerfabricController@print');

Route::get('/markerdesc/{id}', 'MarkerdescController@index');
Route::post('/markerdesc/new', 'MarkerdescController@new');
Route::post('/markerdesc/update', 'MarkerdescController@update');
Route::get('/markerdesc/delete/{id}', 'MarkerdescController@delete');

Route::get('/salessamples', 'SalessamplesController@index');
Route::get('/salessamples/edit/{id}', 'SalessamplesController@edit');
// Route::get('/salessamples/assortment/{id}', 'SalessamplesController@assortment');
Route::post('/salessamples/new', 'SalessamplesController@new');
Route::post('/salessamples/update', 'salessamplesController@update');
Route::get('/salessamples/delete/{id}', 'SalessamplesController@delete');

Route::get('/assortment/{id}', 'AssortmentController@index');
Route::post('assortment/new', 'AssortmentController@new');
Route::get('/assortment/delete/{id}', 'AssortmentController@delete');
Route::get('/assortment/edit/{id}', 'AssortmentController@edit');
Route::post('/assortment/update', 'AssortmentController@update');

Route::get('/salessamples/sizespecs/{id}', 'SizespecsController@index');
Route::get('/salessamples/sizespecs/delete/{id}', 'SizespecsController@delete');
Route::get('/salessamples/sizespecs/edit/{id}', 'SizespecsController@edit');
Route::post('/salessamples/sizespecs/new', 'SizespecsController@new');
Route::post('/salessamples/sizespecs/update', 'SizespecsController@update');

Route::get('/salessamples/remark/{id}', 'RemarkController@index');
Route::post('/salessamples/remark/new/{id}', 'RemarkController@new');
Route::post('/salessamples/remark/update/{id}', 'RemarkController@update');

Route::get('/salessamples/remark_type/{id_sales_sample}', 'RemarkTypeController@index');
Route::get('/salessamples/remark_type/delete/{id}/{id_sales_sample}', 'RemarktypeController@delete');
Route::get('/salessamples/remark_type/getdatabyid', 'RemarkTypeController@getDataById');
Route::post('/salessamples/remark_type/new/{id_sales_sample}', 'RemarkTypeController@new');
Route::post('/salessamples/remark_type/update/{id_sales_sample}', 'RemarkTypeController@update');

Route::get('/salessamples/materialrequirements/get_detail/', 'MaterialreqController@get_detail')->name('materialrequirements.get_detail');
Route::get('/salessamples/materialrequirements/{id_sales_sample}', 'MaterialreqController@index');
Route::get('/salessamples/materialrequirements/delete/{id}/{id_sales_sample}', 'MaterialreqController@delete');
Route::get('/salessamples/materialrequirements/edit/{id}/{id_sales_sample}', 'MaterialreqController@edit');
Route::post('/salessamples/materialrequirements/hapus_detail', 'MaterialreqController@hapus_detail');
Route::post('/salessamples/materialrequirements/getData', 'MaterialreqController@getData');
Route::post('/salessamples/materialrequirements/update_detail', 'MaterialreqController@update_detail');
Route::post('/salessamples/materialrequirements/tambah_detail', 'MaterialreqController@tambah_detail');
Route::post('/salessamples/materialrequirements/update/{id_sales_sample}', 'MaterialreqController@update');
Route::post('/salessamples/materialrequirements/new/{id_sales_sample}', 'MaterialreqController@new');

Route::get('/salessamples/image/{id}', 'SampleImageController@index');
Route::get('/salessamples/image/delete/{id}/{id_sales_sample}', 'SampleImageController@delete');
Route::get('/salessamples/image/edit/{id}/{id_sales_sample}', 'SampleImageController@edit');
Route::post('/salessamples/image/upload/{id_sales_sample}', 'SampleImageController@upload');
Route::post('/salessamples/image/update/', 'SampleImageController@update');

Route::get('/salesorders', 'SalesordersController@index');
Route::get('/salesorders/edit/{id}', 'SalesordersController@edit');
Route::get('/salesorders/{id}', 'SalesordersController@detail');
Route::post('/salesorders/new', 'SalesordersController@new');
Route::post('/salesorders/update', 'SalesordersController@update');
Route::get('/salesorders/delete/{id}', 'SalesordersController@delete');
Route::post('/salesorders/getQuotation', 'SalesordersController@getQuotation')->name('salesorders.getquotation');

Route::get('/so_assortment/{id}', 'SO_AssortmentController@index');
Route::post('/so_assortment/new', 'SO_AssortmentController@new');
Route::get('/so_assortment/delete/{id}', 'SO_AssortmentController@delete');
Route::get('/so_assortment/edit/{id}', 'SO_AssortmentController@edit');
Route::post('/so_assortment/update', 'SO_AssortmentController@update');

Route::get('/salesorders/sizespecs/{id}', 'SO_SizespecsController@index');
Route::get('/salesorders/sizespecs/delete/{id}', 'SO_SizespecsController@delete');
Route::get('/salesorders/sizespecs/edit/{id}', 'SO_SizespecsController@edit');
Route::post('/salesorders/sizespecs/new', 'SO_SizespecsController@new');
Route::post('/salesorders/sizespecs/update', 'SO_SizespecsController@update');

Route::get('/salesorders/remark/{id}', 'SO_RemarkController@index');
Route::post('/salesorders/remark/new/{id}', 'SO_RemarkController@new');
Route::post('/salesorders/remark/update/{id}', 'SO_RemarkController@update');

Route::get('/salesorders/remark_type/{id_sales_order}', 'SO_RemarkTypeController@index');
Route::get('/salesorders/remark_type/delete/{id}/{id_sales_order}', 'SO_RemarktypeController@delete');
Route::get('/salesorders/remark_type/getdatabyid', 'SO_RemarkTypeController@getDataById');
Route::post('/salesorders/remark_type/new/{id_sales_order}', 'SO_RemarkTypeController@new');
Route::post('/salesorders/remark_type/update/{id_sales_order}', 'SO_RemarkTypeController@update');

Route::get('/salesorders/materialrequirements/get_detail/', 'SO_MaterialreqController@get_detail')->name('so_materialrequirements.get_detail');
Route::get('/salesorders/materialrequirements/{id_sales_order}', 'SO_MaterialreqController@index');
Route::get('/salesorders/materialrequirements/delete/{id}/{id_sales_order}', 'SO_MaterialreqController@delete');
Route::get('/salesorders/materialrequirements/edit/{id}/{id_sales_order}', 'SO_MaterialreqController@edit');
Route::post('/salesorders/materialrequirements/hapus_detail', 'SO_MaterialreqController@hapus_detail');
Route::post('/salesorders/materialrequirements/getData', 'SO_MaterialreqController@getData');
Route::post('/salesorders/materialrequirements/update_detail', 'SO_MaterialreqController@update_detail');
Route::post('/salesorders/materialrequirements/tambah_detail', 'SO_MaterialreqController@tambah_detail');
Route::post('/salesorders/materialrequirements/update/{id_sales_order}', 'SO_MaterialreqController@update');
Route::post('/salesorders/materialrequirements/new/{id_sales_order}', 'SO_MaterialreqController@new');


Route::get('/salesorders/image/{id}', 'SO_ImageController@index');
Route::get('/salesorders/image/delete/{id}/{id_sales_order}', 'SO_ImageController@delete');
Route::get('/salesorders/image/edit/{id}/{id_sales_order}', 'SO_ImageController@edit');
Route::post('/salesorders/image/upload/{id_sales_order}', 'SO_ImageController@upload');
Route::post('/salesorders/image/update/', 'SO_ImageController@update');

Route::get('/quotation', 'QuotationController@index');
Route::get('/quotation/view/{id}', 'QuotationController@view');
Route::get('/quotation/new', 'QuotationController@new_form');
Route::post('/quotation/create', 'QuotationController@create');
Route::get('/quotation/edit/{id}', 'QuotationController@edit_form');
Route::get('/quotation/cloning/{id}', 'QuotationController@clone_form');
Route::post('/quotation/update', 'QuotationController@update');

Route::get('/quotation/import', 'QuotationController@import');
Route::post('/quotation/getValue', 'QuotationController@getValue');

Route::get('/consumption', 'ConsumptionController@index');
Route::get('/consumption/delete/{id}', 'ConsumptionController@delete');
Route::get('/consumption/edit/{id}', 'ConsumptionController@edit');
Route::post('/consumption/create', 'ConsumptionController@create');
Route::post('/consumption/update', 'ConsumptionController@update');
Route::get('/consumption/view/{id}', 'ConsumptionController@view');
Route::get('/consumption/update_status/{id}/{status}', 'ConsumptionController@update_status');
Route::post('/consumption/add_detail', 'ConsumptionController@add_detail');
Route::get('/consumption/delete_detail/{id_detail}/{id_consumption}', 'ConsumptionController@delete_detail');
Route::get('/consumption/edit_detail_form', 'ConsumptionController@edit_detail_form');
Route::post('/consumption/update_detail', 'ConsumptionController@update_detail');
Route::get('/consumption/newItem_Fabric',function(){
    return View::make('consumption.new_item_fabric')->render();
});
Route::post('/consumption/add_detail/fabric', 'ConsumptionController@add_fabric_item');
Route::post('/consumption/add_detail/add_supplier_collar_cuff', 'ConsumptionController@add_supplier_collar_cuff');
Route::get('consumption/editDetailSupplierForm/', 'ConsumptionController@editDetailSupplierForm');
Route::post('/consumption/edit_detail/update_fabricItem', 'ConsumptionController@update_fabricItem');
Route::get('/consumption/delete_supplier/{id}/{id_consumption}', 'ConsumptionController@delete_supplier');
Route::get('/consumption/newcollarcuffItemForm/', 'ConsumptionController@newcollarcuffItemForm');
Route::post('/consumption/add_detail/new_collar_cuff_item/', 'ConsumptionController@add_collar_cuff_item');
Route::get('/consumption/editcollarcuffItemForm/', 'ConsumptionController@editcollarcuffItemForm');
Route::post('/consumption/edit_detail/update_collar_cuff_item/', 'ConsumptionController@update_collar_cuff_item');

Route::get('/consumption/delete_collar_cuff_item/{id}/{id_consumption}', 'ConsumptionController@delete_collar_cuff_item');
Route::get('/consumption/print_consumption/{id}', 'ConsumptionController@print_consumption');
Route::get('/consumption/print_purchase_request/{id}', 'ConsumptionController@print_purchase_request');
