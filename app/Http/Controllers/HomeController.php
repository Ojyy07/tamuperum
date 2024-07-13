<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tamu;
use App\Models\Warga;
use App\Models\Keperluan;
use Illuminate\Support\Facades\Log;
date_default_timezone_set('Asia/Ujung_Pandang');

class HomeController extends Controller
{
	public function cek_login(Request $request)
	{
		if (!empty($request->username) OR !empty($request->password)) {
			if (Auth::attempt(['username'=>$request->username,'password'=>$request->password]) OR Auth::attempt(['email'=>$request->username,'password'=>$request->password])) {
				if (Auth::user()->level == 'Admin') {
					return response()->json([
						'masuk_user' => route('dashboard')
					]);
				}elseif(Auth::user()->level == 'Leader Security'){
					return response()->json([
						'masuk_user' => route('dashboard')
					]);
				}else{
					return response()->json([
						'masuk_user' => route('data_tamu')
					]);
				}
			}else{
				return response()->json([
					'notmasuk' => '-'
				]);
			}
		}else{
			return response()->json([
				'kosong' => '-'
			]);
		}
	}
	public function logout()
	{
		Auth::logout();
		return redirect('/');
	}
	public function index()
	{
		$pegawai = Warga::get_warga();
		$company = DB::table('profil_settings')->limit('1')->first();
		$keperluan = Keperluan::get_data();
		return view('index',compact('pegawai','company','keperluan'));
	}
	public function save_tamu(Request $request)
	{
		try {
			DB::beginTransaction();
			if (isset($request->foto_tamu)) {
				$img = $request->foto_tamu;
				$folderPath = public_path('foto/');
				$image_parts = explode(";base64,", $img);
				$image_type_aux = explode("foto/", $image_parts[0]);
				$image_base64 = base64_decode($image_parts[1]);
				$fileName = uniqid() . '.png';
				$file = $folderPath . $fileName;
				file_put_contents($file, $image_base64);
			}else{
				$fileName = NULL;
			}
			$tamu = New Tamu();
			$tamu -> id_warga = $request->id_warga;
			$tamu -> id_keperluan = $request->id_keperluan;
			$tamu -> nama_tamu = $request->nama_tamu;
			$tamu -> tanggal_tamu = date('Y-m-d');
			$tamu -> save();
			DB::table('tamu_detail')->insert([
				'id_tamu'=>$tamu->id_tamu,
				'jekel_tamu'=>$request->jekel_tamu,
				'jenis_kendaraan'=>$request->jenis_kendaraan,
				'no_plat'=>$request->no_plat,
				'jumlah_tamu'=>$request->jumlah_tamu,
				'foto_tamu'=>$fileName,
				'alamat_tamu'=>$request->alamat_tamu
			]);
			DB::commit();
			return response()->json(['status'=>'true','message'=>'Tamu berhasil ditambahkan !!']);
		} catch (Exception $e) {
			DB::rollBack();
		}
	}
}
