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
Route::group(['middleware'    => 'auth'],function(){
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::get('/pdf', 'HomeController@pdf')->name('pdf');
    

    Route::group(['prefix' => 'pengaturan'], function(){
        Route::get('/', 'PengaturanController@index')->name('pengaturan');
        Route::post('/simpan_foto/', 'PengaturanController@simpan_foto');
        
        
    });

    Route::group(['prefix' => 'aplikasi'], function(){
        Route::get('/', 'AplikasiController@index');
        Route::get('/hapus/{id}', 'AplikasiController@hapus');
        Route::post('/edit/{id}', 'AplikasiController@edit');
        Route::post('/simpan/', 'AplikasiController@simpan');
        
        
    });

    Route::group(['prefix' => 'inews'], function(){
        Route::get('/', 'InewsController@index');
        Route::get('/hapus/{id}', 'InewsController@hapus');
        Route::post('/edit/{id}', 'InewsController@edit');
        Route::post('/simpan/', 'InewsController@simpan');
        
        
    });

    Route::group(['prefix' => 'pengumuman'], function(){
        Route::get('/', 'PengumumanController@index');
        Route::get('/hapus/{id}', 'PengumumanController@hapus');
        Route::post('/edit/{id}', 'PengumumanController@edit');
        Route::post('/simpan/', 'PengumumanController@simpan');
        
        
    });

    Route::group(['prefix' => 'cuti'], function(){
        Route::get('/', 'CutiController@index');
        Route::get('/admin', 'CutiController@index_admin');
        Route::get('/validasi_all', 'CutiController@validasi_all');
        Route::get('/tolak_validasi_all', 'CutiController@tolak_validasi_all');
        Route::get('/acc', 'CutiController@index_acc');
        Route::get('/persetujuan', 'CutiController@index_persetujuan');
        Route::get('/persetujuan_selesai', 'CutiController@index_persetujuan_selesai');
        Route::get('/hapus/{id}', 'CutiController@hapus');
        Route::post('/edit/{id}', 'CutiController@edit');
        Route::post('/simpan/', 'CutiController@simpan');
        Route::post('/validasi_data/{id}', 'CutiController@validasi');
        
        
    });
    
    Route::group(['prefix' => 'user'], function(){
        Route::get('/', 'UserController@index');
        Route::get('/akses', 'UserController@index_akses');
        Route::get('/hapus/{id}', 'UserController@hapus');
        Route::post('/edit/{id}', 'UserController@edit');
        Route::post('/simpan/', 'UserController@simpan');
        Route::post('/import_data/', 'UserController@import_data');
        Route::post('/simpan_akses/{id}/{nik}', 'UserController@simpan_akses');
        
    });
});

