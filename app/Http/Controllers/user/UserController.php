<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\tbl_detail_profile_jwb;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

        return view('user-profile');
    }

    public function profileDetail()
    {
        $token = session('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(config('app.api_url') . 'detail-profile');

        $data = $response->json();
        $result = $data['data'];

        $result = collect($result);

        return view('user-profile-dtl', compact('result'));
    }

    public function postProfile(Request $request)
    {
        $data = $request->all();

        foreach ($data as $profileId => $answer) {
            $userId = session()->id;

            tbl_detail_profile_jwb::updateOrInsert(
                ['jwb_userid' => $userId, 'jwb_id' => $profileId],
                ['jwb_jawaban' => $answer, 'jwb_date' => now()]
            );
        }

        return redirect()->back()->with('success', 'Sukses');
    }

    public function showEditUserProfileForm()
    {
        $token = session('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(config('app.api_url') . 'detail-profile');

        $data = $response->json();
        $result = $data['data'];

        return view('user-profile-edit', ['data' => $result]);

        // $options = json_decode('[{"area jabodetabek":0,"pulau Jawa diluar area jabodetabek":1,"luar pulau Jawa":2}]');
        // dd($options);
    }


    public function showEditUserGeneral()
    {
        return view('user-profile-edit-general');
    }

    public function changePassword(Request $request)
    {


        $token = session('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put(config('app.api_url') . '/user/changepassword', [
            'username' => $request->input('username'),
            'password' => $request->input('newpassword'),
        ]);

        if ($response->successful()) {
            return redirect('/user-profile')->with('success', 'Change password successful');
        } else {
            return redirect('/user-profile')->with('error', 'Change password failed');
        }
    }

    public function showNotifPage()
    {
        return view('notifikasi');
    }
}
