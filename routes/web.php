<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;

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
Route::get('clear_cache', function () {
	\Artisan::call('config:cache');
	\Artisan::call('cache:clear');
	dd("Sudah Bersih nih!, Silahkan Kembali ke Halaman Utama");
});

Route::get('/', function () {
	if (Auth::user()) {
		if (Auth::user()->level == 'Admin') {
			return redirect(route('dashboard'));
		}else{
			return redirect(route('data_tamu'));
		}
	}
	return view('login');
})->name('index');
// Route::get('/',[HomeController::class,'index'])->name('index');

Route::post('login/auth-cek',[HomeController::class,'cek_login'])->name('ceklogin');
Route::get('page/auth/logout',[HomeController::class,'logout'])->name('logout');

Route::group(['middleware'=>['auth','ceklevel:Admin,Leader Security,Security']],function()
{
	Route::post('page/profile/update',[DashboardController::class,'update_profile'])->name('update_profile');
});
Route::group(['middleware'=>['auth','ceklevel:Security']],function()
{
	Route::get('page/data-tamu',[TamuController::class,'data_tamu'])->name('data_tamu');
	Route::post('create-tamu/action/save',[HomeController::class,'save_tamu'])->name('save_tamu');
	Route::get('page/data-tamu/destroy/{id_tamu}',[TamuController::class,'hapus_tamu'])->name('hapus_tamu');
	Route::get('page/data-tamu/getEdit',[TamuController::class,'get_edit'])->name('get_edit');
	Route::post('page/data-tamu/update',[TamuController::class,'update_tamu'])->name('update_tamu');
});
Route::group(['middleware'=>['auth','ceklevel:Admin,Leader Security']],function()
{
	Route::get('page/dashboard',[DashboardController::class,'index'])->name('dashboard');
	Route::get('page/dashboard/getTamu',[DashboardController::class,'get_tamu_dash'])->name('get_tamu_dash');

	Route::get('page/rekap-tamu',[TamuController::class,'rekap_tamu'])->name('rekap_tamu');
	Route::get('page/rekap-tamu/export',[TamuController::class,'export_rekap_tamu'])->name('export_rekap_tamu');
});
Route::group(['middleware'=>['auth','ceklevel:Leader Security']],function()
{
	Route::get('page/data-keperluan',[MasterController::class,'data_keperluan'])->name('data_keperluan');
	Route::post('page/data-keperluan/save',[MasterController::class,'save_keperluan'])->name('save_keperluan');
	Route::get('page/data-keperluan/getEdit/{id_keperluan}',[MasterController::class,'get_edit_keperluan'])->name('get_edit_keperluan');
	Route::get('page/data-keperluan/destroy/{id_keperluan}',[MasterController::class,'delete_keperluan'])->name('delete_keperluan');

	Route::get('page/data-warga',[MasterController::class,'data_warga'])->name('data_warga');
	Route::post('page/data-warga/save',[MasterController::class,'save_warga'])->name('save_warga');
	Route::get('page/data-warga/getEdit/{id_warga}',[MasterController::class,'get_edit_warga'])->name('get_edit_warga');
	Route::get('page/data-warga/destroy/{id_warga}',[MasterController::class,'delete_warga'])->name('delete_warga');
});
Route::group(['middleware'=>['auth','ceklevel:Admin']],function()
{
	Route::get('page/data-user',[MasterController::class,'data_user'])->name('data_user');
	Route::post('page/data-user/save',[MasterController::class,'save_user'])->name('save_user');
	Route::get('page/data-user/getEdit/{id}',[MasterController::class,'get_edit_user'])->name('get_edit_user');
	Route::post('page/data-user/update',[MasterController::class,'update_user'])->name('update_user');
	Route::get('page/data-user/destroy/{id}',[MasterController::class,'delete_user'])->name('delete_user');

	Route::get('page/profil/settings',[SettingsController::class,'profil_setting'])->name('profil_setting');
	Route::post('page/profil/settings/update',[SettingsController::class,'update_profil_setting'])->name('update_profil_setting');
});
// Route::post('page/data-keperluan/update',[MasterController::class,'save_keperluan'])->name('save_keperluan');