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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('vendor', 'VendorController');
Route::resource('/um', 'UnitofmeasurementController');
Route::resource('/category', 'ItemCategoryController');
Route::resource('/role', 'RoleController');
Route::resource('/members', 'MemberController');
Route::resource('/location', 'LocationController');
Route::resource('item', 'ItemController');
Route::resource('quotation', 'QuotationController');
Route::resource('purchase', 'PurchaseController');
Route::POST('filter', 'ItemController@filter')->name('filter');
Route::get('export_pdf', 'ItemController@export_pdf')->name('export_pdf');
Route::get('export_quotation/{id}', 'QuotationController@export_quotation')->name('export_quotation');
Route::resource('/department', 'DepartmentController');
Route::resource('/brand', 'BrandController');
Route::post('/purchase/fetch', 'PurchaseController@fetch')->name('fetch');
Route::post('/purchase/updateQty', 'PurchaseController@updateQty')->name('updateQty');
Route::get('/holdStatus', 'PurchaseController@holdStatus')->name('holdStatus');
Route::get('invoice', 'PurchaseController@invoice')->name('invoice');
Route::get('cartRestore', 'PurchaseController@cartRestore')->name('cartRestore');
Route::get('generateInvoiceNumber', 'PurchaseController@generateInvoiceNumber')->name('generateInvoiceNumber');
Route::resource('/item_purchase_history', 'ItemPurchaseHistoryController');
Route::POST('date_filter', 'ItemPurchaseHistoryController@date_filter')->name('date_filter');
Route::get('/unique_invoice/{id}/', 'ItemPurchaseHistoryController@show')->name('show');
Route::get('purchase_history_pdf', 'ItemPurchaseHistoryController@purchase_history_pdf')->name('purchase_history_pdf');

Route::get('importExportView', 'QuotationController@importExportView');
Route::post('import', 'QuotationController@import')->name('import');
Route::resource('rfq', 'RequestForQuotationController');

Route::group(['middleware' => ['role:purchase_manager']], function () {
		Route::get('/home', 'HomeController@index')->name('home');
});

/*$cat_id = 01;
$unit_id = 02;
$cat = str_pad($cat_id, 2, '0', STR_PAD_LEFT);
$unit = str_pad($unit_id, 2, '0', STR_PAD_LEFT);
$item = str_pad($cat_id, 4, '0', STR_PAD_LEFT);
echo $cat.$unit.$item;
//printf("%02d", $cat_id).printf("%02d", $unit_id).printf("%04d", $cat_id);*/