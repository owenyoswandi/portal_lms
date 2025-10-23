<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    //
    function index(){
        /*if (!session()->has('user_id')) {
			return redirect('login');
		}
		else if(session()->has('user_role') == true && session('user_role') == "Admin"){}		
		else{
			return abort(404);
		}*/

        $data = [];
        
        return view('admin/dashboard_admin', $data);
    }

	function profile(){
        /*if (!session()->has('user_id')) {
			return redirect('login');
		}
		else if(session()->has('user_role') == true && session('user_role') == "Admin"){}		
		else{
			return abort(404);
		}*/

        $data = [];
        
        return view('admin/profile', $data);
    }
}
