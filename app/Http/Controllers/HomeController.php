<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_detail_profile;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }
	
	public function profiling()
    {
        return view('profiling');
    }
	
	public function profilingEdit()
    {
		$temp_null = '{"detail_id":4,"user_id":4,"jenjang_pendidikan":"","nama_institusi":"","tahun_masuk":"","tahun_lulus":"","gelar":"","bidang_studi":"","nama_perusahaan":"","posisi":"","periode_mulai":"","periode_selesai":"","tanggung_jawab":"","linkedin":"","twitter":"","instagram":"","facebook":"","github":"","nama_keahlian":"","sumber_keahlian":"","sertifikasi":""}';
		$temp_null = json_decode($temp_null, true);
		
		$data['profiling'] = null;
		$result = tbl_detail_profile::where([
						['user_id', '=', session('id')]
					])->orderBy('detail_id', 'desc')->first();
		
		if ($result != null) {
			$data['profiling'] = $result;
		} else {
			$data['profiling'] = $temp_null;
		}
					
        return view('profiling-edit',$data);
    }
}
