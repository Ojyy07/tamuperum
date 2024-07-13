<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tamu;

class DashboardController extends Controller
{
	public function index(Request $request)
	{
		// $results = Tamu::select(
		// 	DB::raw('COUNT(CASE WHEN kategori_tamu = "Umum" THEN 1 END) as umum'),
		// 	DB::raw('COUNT(CASE WHEN kategori_tamu = "Instansi" THEN 1 END) as instansi'),
		// 	DB::raw('COUNT(CASE WHEN kategori_tamu = "Perusahaan" THEN 1 END) as perusahaan'),
		// 	DB::raw('MONTH(created_at) as month')
		// )
		// ->groupBy('month')
		// ->whereYear('created_at',date('Y'))
		// ->get();
		// $result = Tamu::select(
		// 	DB::raw('COUNT(CASE WHEN kategori_tamu = "Umum" THEN 1 END) as umum'),
		// 	DB::raw('COUNT(CASE WHEN kategori_tamu = "Instansi" THEN 1 END) as instansi'),
		// 	DB::raw('COUNT(CASE WHEN kategori_tamu = "Perusahaan" THEN 1 END) as perusahaan'),
		// 	DB::raw('kategori_tamu as kategori_tamu')
		// )
		// ->groupBy('kategori_tamu')
		// ->whereYear('created_at',date('Y'))
		// ->get();
		// $data = [];
		// for ($month = 1; $month <= 12; $month++) {
		// 	$monthLabel = date('F', mktime(0, 0, 0, $month, 1));
		// 	$data['label'][] = $monthLabel;
		// 	$resultForMonth = $results->firstWhere('month', $month);
		// 	$data['data']['umum'][] = $resultForMonth ? $resultForMonth->umum : 0;
		// 	$data['data']['instansi'][] = $resultForMonth ? $resultForMonth->instansi : 0;
		// 	$data['data']['perusahaan'][] = $resultForMonth ? $resultForMonth->perusahaan : 0;
		// }
		// foreach ($result as $rows) {
		// 	$data['label_jml'][] = $rows->kategori_tamu;
		// 	$data['data_jml']['umum'][] = $rows->umum;
		// 	$data['data_jml']['perusahaan'][] = $rows->perusahaan;
		// 	$data['data_jml']['instansi'][] = $rows->instansi;
		// }
		
		// $data['chart_data'] = json_encode($data);
		$result = Tamu::where('tanggal_tamu',date('Y-m-d'))
		->where('read_tamu','0');
		$cek = clone $result;
		$cek = $cek->count();
		if ($cek > 0) {
			$update = clone $result;
			$update = $update->update([
				'read_tamu'=>'1'
			]);
		}
		$tamu_harian = Tamu::where('tanggal_tamu',date('Y-m-d'))->count();
		$tamu_all = Tamu::count();
		$data = Tamu::getTamuDash();
		return view('page.admin.dashboard.index',compact('tamu_harian','tamu_all','data'));
	}
	public function get_tamu_dash()
	{
		$data = Tamu::where('tanggal_tamu',date('Y-m-d'))
		->where('read_tamu','0')
		->count();
		return response()->json($data);
		// return ['data'=>$data,'level'=>$level];
	}

	public function update_profile(Request $request)
	{
		if (isset($request->password_user)) {
			if ($request->confirm_password_user != $request->password_user) {
				$message = 'Konfirmasi Password tidak sesuai.';
				return response()->json(['status'=>'password','message'=>$message]);
			}
		}
		$data = User::where('id',$request->id_user)->first();
		$data -> name = $request->name_user;
		$data -> username = $request->username_user;
		$data -> email = $request->email_user;
		if ($request->password_user != '') {
			$data -> password = hash::make($request->password_user);
		}
		$data -> save();
		if (!empty($request->file('foto_user'))) {
			$files = $request->file('foto_user');
			$foto = $files->getClientOriginalName();
			$namaFileBaru = uniqid();
			$namaFileBaru .= $foto;
			$files->move(\base_path() . "/public/foto", $namaFileBaru);
		}else{
			$namaFileBaru = $request->fotoLama_user;
		}
		DB::table('biodata')->where('id_users',$request->id_user)->update([
			'telepon'=>$request->telepon_user,
			'foto'=>$namaFileBaru
		]);
		$message = 'Profile berhasil diperbarui !!';
		return response()->json(['status'=>'true','message'=>$message]);
	}
}
