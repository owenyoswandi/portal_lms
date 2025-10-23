<?php

namespace App\Http\Controllers;

use App\Models\tbl_user;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ForumController extends Controller
{
    public $subjectDropdown = [
        'Obat',
        'Gejala/Keluhan',
        'Kunjungan/Kontrol Dokter',
        'Lainnya'
    ];

    public function index()
    {
        $token = session('token');
        $role = session('role');
        $id = session('id');

        if($role != 'Pasien'){
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'X-Rumah-Sakit'=> session('rumah_sakit')
            ])->get(config('app.api_url') . 'konsultasi');
        }else{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get(config('app.api_url') . 'konsultasi-byuserid/'.$id);
        }
       

        $data = $response->json();
        if ($data) {
            $forum = $this->enrichForumData($data['data'], 'fr');
            return view('forum', ['data' => $forum, 'subject_dropdown' => $this->subjectDropdown]);
        } else {
            return view('login')->with('error', 'Unauthorized');
        }
    }

    private function enrichForumData($forumData, $awalan)
    {
        foreach ($forumData as &$forum) {
            $forum['formatted_createddate'] = Carbon::parse($forum[$awalan . '_createddate'])->format('d-m-Y H:i:s');
            $forum['formatted_modifieddate'] = Carbon::parse($forum[$awalan . '_modifieddate'])->format('d-m-Y H:i:s');
            $userId = $forum[$awalan . '_modifiedby'];
            $userDetails = tbl_user::where('user_id', $userId)->first();
            $forum['username'] = $userDetails->nama;
            if ($awalan == 'frd') {
                $forum['role'] = $userDetails->role;
            }
        }

        if ($awalan == 'fr') {
            usort($forumData, function ($a, $b) use ($awalan) {
                return strtotime($b[$awalan . '_modifieddate']) - strtotime($a[$awalan . '_modifieddate']);
            });
        }


        return $forumData;
    }

    public function forumView($id)
    {
        $token = session('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(config('app.api_url') . 'konsultasi-detail');

        $data = $response->json();
        $filteredData = $this->filterByFrdFrId($data['data'], $id);
        $result = $this->enrichForumData($filteredData, 'frd');

        $forumJudul = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(config('app.api_url') . 'konsultasi/' . $id);

        $dataJudul = $forumJudul->json();
        if ($dataJudul) {
            $judul = $this->enrichForumData($dataJudul['data'], 'fr');
            return view('forum_dtl', ['data' => $result, 'judul' => $judul[0]]);
        }else{
            return view('login')->with('error', 'Unauthorized');
        }
    }

    private function filterByFrdFrId($forumData, $frdFrId)
    {
        return array_filter($forumData, function ($forum) use ($frdFrId) {
            return $forum['frd_fr_id'] == $frdFrId;
        });
    }
}
