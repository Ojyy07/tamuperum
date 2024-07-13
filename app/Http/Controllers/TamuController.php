<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Keperluan;
use App\Models\Tamu;
use App\Models\Warga;
use PDF;
date_default_timezone_set('Asia/Jakarta');

class TamuController extends Controller
{
	public function data_tamu(Request $request)
	{
		$data = Tamu::getTamu($request);
		$pegawai = Warga::get_warga();
		$keperluan = Keperluan::get_data();
		return view('page.admin.tamu.index',compact('data','pegawai','keperluan'));
	}
	public function get_edit(Request $request)
	{
		$data = Tamu::getEditTamu($request);
		return response()->json($data);
	}
	public function update_tamu(Request $request)
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
				$fileName = $request->foto_tamuLama;
			}
			$tamu = Tamu::where('id_tamu',$request->id_tamu)->first();
			$tamu -> id_warga = $request->id_warga;
			$tamu -> id_keperluan = $request->id_keperluan;
			$tamu -> nama_tamu = $request->nama_tamu;
			$tamu -> save();
			DB::table('tamu_detail')->where('id_tamu',$request->id_tamu)->update([
				'jekel_tamu'=>$request->jekel_tamu,
				'jenis_kendaraan'=>$request->jenis_kendaraan,
				'no_plat'=>$request->no_plat,
				'jumlah_tamu'=>$request->jumlah_tamu,
				'foto_tamu'=>$fileName,
				'alamat_tamu'=>$request->alamat_tamu
			]);
			DB::commit();
			return response()->json(['status'=>'true','message'=>'Edit Data Tamu berhasil !!']);
		} catch (Exception $e) {
			DB::rollBack();
		}
	}
	public function hapus_tamu($id_tamu)
	{
		$tamu = Tamu::where('id_tamu',$id_tamu)->first();
		if ($tamu) {
			DB::table('tamu_detail')->where('id_tamu',$id_tamu)->delete();
			$tamu -> delete();
		}
	}
	public function rekap_tamu(Request $request)
	{
		$data = Tamu::getTamu($request);
		return view('page.admin.rekap.index',compact('data'));
		// $pdf=PDF::loadview('page.pembina.laporan.absensi.export',compact('data'))->setPaper('A4','landscape');
		// return $pdf->stream();
	}
	public function export_rekap_tamu(Request $request)
	{
		$data = Tamu::getTamu($request);
		if ($request->type == 'PDF') {
			$pdf=PDF::loadview('page.admin.rekap.export',compact('data'))->setPaper('A4','landscape');
			return $pdf->stream();
		}else{
			return view('page.admin.rekap.export',compact('data'));
		}
	}
}
