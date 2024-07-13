<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Keperluan;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\warga;
date_default_timezone_set('Asia/Ujung_Pandang');

class MasterController extends Controller
{
	public function data_keperluan()
	{
		$data = Keperluan::get_data();
		return view('page.admin.keperluan.index',compact('data'));	
	}
	public function save_keperluan(Request $request)
	{
		if ($request->id_keperluan == '') {
			$data = New Keperluan();
			$message = 'Data keperluan berhasil ditambahkan !!';
		}else{
			$data = Keperluan::where('id_keperluan',$request->id_keperluan)->first();
			$message = 'Data keperluan berhasil diubah !!';
		}
		$data -> nama_keperluan = $request->nama_keperluan;
		$data -> save();
		return response()->json(['status'=>'true','message'=>$message]);
	}
	public function get_edit_keperluan($id_keperluan)
	{
		$data = Keperluan::getEdit($id_keperluan);
		return response()->json($data);
	}
	public function delete_keperluan($id_keperluan)
	{
		$data = Keperluan::where('id_keperluan',$id_keperluan)->first();
		if ($data) {
			$data -> delete();
		}
	}

	public function data_warga()
	{
		$data = Warga::get_warga();
		$keperluan = Keperluan::get_data();
		return view('page.admin.warga.index',compact('data','keperluan'));
	}
	public function save_warga(Request $request)
	{
		if ($request->id_warga == '') {
			$data = New Warga();
			$message = 'Data warga berhasil ditambahkan !!';
		}else{
			$data = Warga::where('id_warga',$request->id_warga)->first();
			$message = 'Data warga berhasil diubah !!';
		}
		$data -> nama_warga = $request->nama_warga;
		$data -> nik_warga = $request->nik_warga;
		$data -> email_warga = $request->email_warga;
		$data -> telepon_warga = $request->telepon_warga;
		$data -> alamat_warga = $request->alamat_warga;
		$data -> status_warga = $request->status_warga;
		$data -> keterangan = $request->keterangan;
		$data -> save();
		return response()->json(['status'=>'true','message'=>$message]);
	}
	public function get_edit_warga($id_warga)
	{
		$data = Warga::getEdit($id_warga);
		return response()->json($data);
	}
	public function delete_warga($id_warga)
	{
		$data = Warga::where('id_warga',$id_warga)->first();
		if ($data) {
			$data -> delete();
		}
	}

	public function data_user()
	{
		$data = User::get_user();
		return view('page.admin.user.index',compact('data'));
	}
	public function save_user(Request $request)
	{
		try {
			DB::beginTransaction();
			if (isset($request->password)) {
				if ($request->confirm_password != $request->password) {
					$message = 'Konfirmasi Password tidak sesuai.';
					return response()->json(['status'=>'password','message'=>$message]);
				}
			}
			$data = New User();
			$data -> name = $request->name;
			$data -> username = $request->username;
			$data -> email = $request->email;
			if ($request->password != '') {
				$data -> password = hash::make($request->password);
			}
			$data -> level = $request->level;
			$data -> save();
			if (!empty($request->file('foto'))) {
				$files = $request->file('foto');
				$foto = $files->getClientOriginalName();
				$namaFileBaru = uniqid();
				$namaFileBaru .= $foto;
				$files->move(\base_path() . "/public/foto", $namaFileBaru);
			}else{
				$namaFileBaru = NULL;
			}
			DB::table('biodata')->insert([
				'id_users'=>$data->id,
				'nik'=>$request->nik,
				'telepon'=>$request->telepon,
				'foto'=>$namaFileBaru
			]);
			$message = 'Data User berhasil ditambahkan !!';
			DB::commit();
			return response()->json(['status'=>'true','message'=>$message]);
		} catch (\Exception $e) {
			DB::rollBack();
			Log::error($e);
			return response()->json(['status' => 'false', 'message' => 'Permintaan Data terjadi kesalahan !! [' . $e->getMessage() . ']']);
		}
	}

	public function get_edit_user($id)
	{
		$data = User::getEdit($id);
		return response()->json($data);
	}
	public function update_user(Request $request)
	{
		if (isset($request->password)) {
			if ($request->confirm_password != $request->password) {
				$message = 'Konfirmasi Password tidak sesuai.';
				return response()->json(['status'=>'password','message'=>$message]);
			}
		}
		$data = User::where('id',$request->id)->first();
		$data -> name = $request->name;
		$data -> username = $request->username;
		$data -> email = $request->email;
		if ($request->password != '') {
			$data -> password = hash::make($request->password);
		}
		$data -> level = $request->level;
		$data -> save();
		if (!empty($request->file('foto'))) {
			$files = $request->file('foto');
			$foto = $files->getClientOriginalName();
			$namaFileBaru = uniqid();
			$namaFileBaru .= $foto;
			$files->move(\base_path() . "/public/foto", $namaFileBaru);
		}else{
			$namaFileBaru = $request->fotoLama;
		}
		DB::table('biodata')->where('id_users',$request->id)->update([
			'nik'=>$request->nik,
			'telepon'=>$request->telepon,
			'foto'=>$namaFileBaru
		]);
		$message = 'Data User berhasil diubah !!';
		return response()->json(['status'=>'true','message'=>$message]);
	}
	public function delete_user($id)
	{
		$data = User::where('id',$id)->first();
		if ($data) {
			DB::table('biodata')->where('id_users',$id)->delete();
			$data -> delete();
		}
	}
}
