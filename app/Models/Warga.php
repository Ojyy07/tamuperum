<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    // use HasFactory;
    protected $table="warga";
	protected $primaryKey="id_warga";

	public static function get_warga()
	{
		$data = DB::table('warga')
		->orderBy('warga.id_warga','DESC')->get();
		return $data;
	}
	public static function getEdit($id_warga)
	{
		$data = DB::table('warga')
		->where('warga.id_warga',$id_warga)
		->get();
		return $data;
	}
}
