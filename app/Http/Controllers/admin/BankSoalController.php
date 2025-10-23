<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\tbl_pertanyaan;
use App\Models\tbl_product;

class BankSoalController extends Controller
{
    function index()
    {
        $data = [];

        return "";
    }
	
	function question(){
        $data['data_course'] = tbl_product::where([
					['p_jenis', '=', "course"],
					['p_status', '=', "1"]
				])->get();
        
        return view('admin/question', $data);
    }
	
	function question_choice($id = null){
        $data['data_course'] = tbl_product::where([
					['p_jenis', '=', "course"],
					['p_status', '=', "1"]
				])->get();
				
		$data['data_pertanyaan'] = tbl_pertanyaan::where([
					['pertanyaan_id', '=', $id]
				])->first();
        
        return view('admin/question_choice', $data);
    }

}
