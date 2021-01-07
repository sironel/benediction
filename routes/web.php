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

Route::get('test', function () {
    return (client());
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/prix-produit', 'PrixVenteController@prix_produit')->middleware('ope');
Route::post('/upload/{id}', 'ProduitController@upload');
Route::resource('/produits', 'ProduitController');
Route::resource('/familles', 'FamilleProduitController');
Route::resource('/fournisseurs', 'FournisseurController');
Route::resource('/achats', 'AchatController');


Route::group(['middleware' =>  ['auth','verified', 'adm']], function () {
    Route::post('/update-prix', 'PrixVenteController@updatePrix');
    Route::get('/prix-to-update', 'PrixVenteController@prix_to_Update');
    Route::get('/admin', 'HomeController@admin');
    Route::get('/create-article', 'ProduitController@indexadm');

    Route::put('/clients', 'ClientController@store');
    Route::get('/getclients', 'ClientController@getclient');
    Route::get('/delclient/{id}', 'ClientController@destroy');
    Route::put('/editclient/{id}', 'ClientController@update');

    Route::put('/stocks', 'StockController@store');
    Route::get('/gstock', 'StockController@index');
    Route::get('/getstocks', 'StockController@getstock');
    Route::get('/delstock/{id}', 'StockController@destroy');
    Route::put('/editstock/{id}', 'StockController@update');

    Route::put('/ventes', 'VenteController@store');
    Route::get('/gvente', 'VenteController@index');
    Route::get('/getventes', 'VenteController@getvente');
    Route::get('/delvente/{id}', 'VenteController@destroy');
    Route::put('/editvente/{id}', 'VenteController@update');

 });


Route::get('file-upload', 'FileUploadController@index');

Route::post('file-upload/upload', 'FileUploadController@upload')->name('upload');

Route::get('/gscom', function(){
  return view('gestioncommande');

});

Route::get('/test2', function(){
  return consult_produits();

});


