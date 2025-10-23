<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\tbl_user;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
		
        $response = Http::post(config('app.api_url') . '/auth/checkLogin', [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ]);
        
        if ($response->successful()) {
           
            $apiData = $response->json();
            if ($apiData['success'] == true) {
                $userId = tbl_user::where('username',$apiData['data'][0]['username'])->value('user_id');
				$url_login = '';
				$link_ems = '';
				$link_pms = '';
				
				$role = $apiData['data'][0]['role'];
				if($role == 'Admin'){
					$url_login = '/home';
					$link_ems = '/admin/course';
					$link_pms = '/admin/project';
				} else if($role == 'Peserta'){
					$url_login = '/member/course';
					$link_ems = '/member/course';
					$link_pms = '/member/project';
				}
				
                session([
                    'id' => $apiData['data'][0]['user_id'],
                    'token' => $apiData['data'][0]['api_token'],
                    'role' => $apiData['data'][0]['role'],
                    'name' => $apiData['data'][0]['nama'],
                    'username' => $apiData['data'][0]['username'],
                    'userid' => $userId,
					'link_ems' => $link_ems,
					'link_pms' => $link_pms,
                ]);

                $request->session()->save();
				
                
				//return redirect($url_login)->with('success', 'Login successful');
				return redirect('/profiling')->with('success', 'Login successful');
				
            }else{
                return redirect('/login')->with('error', 'Invalid username or password');     
            }
        } else {
            return redirect('/login')->with('error', 'Invalid username or password');
        }
    }

    public function logout()
    {
        session()->forget('token');
        return redirect('/login')->with('success', 'Logout successful');
    }
}
