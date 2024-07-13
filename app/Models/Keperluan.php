<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Keperluan extends Model
{
    // use HasFactory;
	protected $table="keperluan";
	protected $primaryKey="id_keperluan";

	public static function get_data()
	{
		$data = DB::table('keperluan')->orderBy('id_keperluan','DESC')->get();
		return $data;
	}
	public static function getEdit($id_keperluan)
	{
		$data = Keperluan::where('id_keperluan',$id_keperluan)->get();
		return $data;
	}
}
