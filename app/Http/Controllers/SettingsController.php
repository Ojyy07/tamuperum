<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tamu;

class SettingsController extends Controller
{
	public function profil_setting()
	{
		$data = DB::table('profil_settings')->limit('1')->get();
		return view('page.admin.settings.profil.index',compact('data'));
	}
	public function update_profil_setting(Request $request)
	{
		if (!empty($request->file('logo_profil'))) {
			$files = $request->file('logo_profil');
			$foto = $files->getClientOriginalName();
			$namaFileBaru = uniqid();
			$namaFileBaru .= $foto;
			$files->move(\base_path() . "/public/foto", $namaFileBaru);
		}else{
			$namaFileBaru = $request->logo_profilLama;
		}
		DB::table('profil_settings')->where('id_profil',$request->id_profil)->update([
			'nama_profil'=>$request->nama_profil,
			'alamat_profil'=>$request->alamat_profil,
			'logo_profil'=>$namaFileBaru
		]);
		return back();;
	}
}
