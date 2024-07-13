<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    // use HasFactory;
	protected $table="tamu";
	protected $primaryKey="id_tamu";

	public static function getTamu($request)
	{
		$data = Tamu::join('tamu_detail','tamu_detail.id_tamu','=','tamu.id_tamu')
		->join('warga','warga.id_warga','=','tamu.id_warga')
		->leftJoin('keperluan','keperluan.id_keperluan','=','tamu.id_keperluan')
		->select(
			\DB::RAW('tamu.id_tamu as id_tamu'),
			\DB::RAW('tamu.nama_tamu as nama_tamu'),
			\DB::RAW('tamu.id_warga as id_warga'),
			\DB::RAW('tamu.created_at as created_at'),
			\DB::RAW('tamu.tanggal_tamu as tanggal_tamu'),
			\DB::RAW('tamu_detail.jekel_tamu as jekel_tamu'),
			\DB::RAW('tamu_detail.jenis_kendaraan as jenis_kendaraan'),
			\DB::RAW('tamu_detail.no_plat as no_plat'),
			\DB::RAW('tamu_detail.alamat_tamu as alamat_tamu'),
			\DB::RAW('tamu_detail.jumlah_tamu as jumlah_tamu'),
			\DB::RAW('tamu_detail.foto_tamu as foto_tamu'),
			\DB::RAW('warga.nama_warga as nama_warga'),
			\DB::RAW('warga.alamat_warga as alamat_warga'),
			\DB::RAW('warga.status_warga as status_warga'),
			\DB::RAW('warga.keterangan as keterangan'),
			\DB::RAW('keperluan.nama_keperluan as nama_keperluan'),
			\DB::RAW('warga.telepon_warga as telepon_warga')
		)
		->orderBy('tamu.id_tamu','DESC');
		if ($request->awal != '') {
			$data->whereBetween('tamu.tanggal_tamu',[$request->awal,$request->akhir]);
		}
		$data = $data->get();
		return $data;
	}
	public static function getEditTamu($request)
	{
		$data = Tamu::join('tamu_detail','tamu_detail.id_tamu','=','tamu.id_tamu')
		->join('warga','warga.id_warga','=','tamu.id_warga')
		->leftJoin('keperluan','keperluan.id_keperluan','=','tamu.id_keperluan')
		->select(
			\DB::RAW('tamu.id_tamu as id_tamu'),
			\DB::RAW('tamu.nama_tamu as nama_tamu'),
			\DB::RAW('tamu.id_warga as id_warga'),
			\DB::RAW('tamu.created_at as created_at'),
			\DB::RAW('tamu_detail.jekel_tamu as jekel_tamu'),
			\DB::RAW('tamu_detail.jenis_kendaraan as jenis_kendaraan'),
			\DB::RAW('tamu_detail.no_plat as no_plat'),
			\DB::RAW('tamu_detail.alamat_tamu as alamat_tamu'),
			\DB::RAW('tamu_detail.jumlah_tamu as jumlah_tamu'),
			\DB::RAW('tamu_detail.foto_tamu as foto_tamu'),
			\DB::RAW('warga.nama_warga as nama_warga'),
			\DB::RAW('warga.alamat_warga as alamat_warga'),
			\DB::RAW('warga.id_warga as id_warga'),
			\DB::RAW('warga.keterangan as keterangan'),
			\DB::RAW('keperluan.nama_keperluan as nama_keperluan'),
			\DB::RAW('keperluan.id_keperluan as id_keperluan')
			// \DB::RAW('warga.telepon_warga as telepon_warga')
		)
		->where('tamu.id_tamu',$request->id_tamu)
		->get();
		return $data;
	}
	public static function getTamuDash()
	{
		$data = Tamu::join('tamu_detail','tamu_detail.id_tamu','=','tamu.id_tamu')
		->join('warga','warga.id_warga','=','tamu.id_warga')
		->leftJoin('keperluan','keperluan.id_keperluan','=','tamu.id_keperluan')
		->select(
			\DB::RAW('tamu.id_tamu as id_tamu'),
			\DB::RAW('tamu.nama_tamu as nama_tamu'),
			\DB::RAW('tamu.id_warga as id_warga'),
			\DB::RAW('tamu.created_at as created_at'),
			\DB::RAW('tamu.tanggal_tamu as tanggal_tamu'),
			\DB::RAW('tamu_detail.jekel_tamu as jekel_tamu'),
			\DB::RAW('tamu_detail.jenis_kendaraan as jenis_kendaraan'),
			\DB::RAW('tamu_detail.no_plat as no_plat'),
			\DB::RAW('tamu_detail.alamat_tamu as alamat_tamu'),
			\DB::RAW('tamu_detail.foto_tamu as foto_tamu'),
			\DB::RAW('tamu_detail.jumlah_tamu as jumlah_tamu'),
			\DB::RAW('warga.nama_warga as nama_warga'),
			\DB::RAW('warga.alamat_warga as alamat_warga'),
			\DB::RAW('keperluan.nama_keperluan as nama_keperluan'),
			\DB::RAW('warga.telepon_warga as telepon_warga')
		)
		->where('tamu.tanggal_tamu',date('Y-m-d'))
		->orderBy('tamu.id_tamu','DESC')
		->limit('5')
		->get();
		return $data;
	}
	public static function getApp()
	{
		$company = DB::table('profil_settings')->limit('1')->first();
		return $company;
	}
}
