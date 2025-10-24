<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\tbl_role_project;
use App\Models\tbl_team_members;
use App\Models\tbl_user;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    //
    function index()
    {
        /*if (!session()->has('user_id')) {
			return redirect('login');
		}
		else if(session()->has('user_role') == true && session('user_role') == "Admin"){}		
		else{
			return abort(404);
		}*/

        $data = [];

        return view('member/dashboard-member', $data);
    }

    function course()
    {
        $data = [];

        return view('member/course', $data);
    }

    function detailcourse($p_id)
    {
        $data['p_id'] = $p_id;

        return view('member/detailcourse', $data);
    }

    function membercard()
    {
        $data = [];

        return view('member/membercard', $data);
    }

    function dashboard_member()
    {
        $data = [];

        return view('member/dashboard_member', $data);
    }

    function order()
    {
        $data = [];

        return view('member/order', $data);
    }

    function topup()
    {
        $data = [];

        return view('member/topup', $data);
    }

    function finance()
    {
        $data = [];

        return view('member/finance', $data);
    }

    function topic($id)
    {
        return view('member/topic', compact('id'));
    }

    function subtopic($p_id, $st_id)
    {
        return view('member/subtopic', compact('p_id', 'st_id'));
    }

    function submission($p_id, $st_id)
    {
        return view('member/submission', compact('p_id', 'st_id'));
    }

    function test($p_id, $st_id, $hasil_id)
    {
        return view('member/test', compact('p_id', 'st_id', 'hasil_id'));
    }

    function projectlist()
    {
        return view('member/project');
    }
    function projectadd()
    {
        return view('member/project_add');
    }
    function projectview($project_id)
    {
        return view('member/project_detail', compact('project_id'));
    }

    function activityview($phase_id, $project_id)
    {
        $userId = session('id');
        $isAdmin = session('role') === 'Admin'; 

        $addActivityAbility = tbl_team_members::join('tbl_role_projects', 'tbl_team_members.rolep_id', '=', 'tbl_role_projects.rolep_id')
            ->where([['tbl_team_members.user_id', $userId], ['tbl_team_members.project_id', $project_id]])
            ->value('tbl_role_projects.add_activity_ability');
        $markDoneActivity = tbl_team_members::join('tbl_role_projects', 'tbl_team_members.rolep_id', '=', 'tbl_role_projects.rolep_id')
            ->where([['tbl_team_members.user_id', $userId], ['tbl_team_members.project_id', $project_id]])
            ->value('tbl_role_projects.mark_done_activity');

        if ($addActivityAbility === null && !$isAdmin) {
            $addActivityAbility = 0;
        } elseif ($isAdmin) {
            $addActivityAbility = 1;
        }

        if ($markDoneActivity === null && !$isAdmin) {
            $markDoneActivity = 0;
        } elseif ($isAdmin) {
            $markDoneActivity = 1;
        }

        return view('member/phase_detail', compact('phase_id', 'addActivityAbility', 'markDoneActivity'));
    }

    function calendar()
    {
        return view('member/calendar');
    }
	
	function certificate($course_id, $subtopic_id){
        $data = [];
        
        require_once("app/Lib/fpdf186/fpdf.php");
		require_once("app/Lib/phpqrcode/qrlib.php");
		
		//$sert_id = $id;
		// get data
		$row=tbl_user::
			where([
				['user_id','=', session('userid')]
			])->first();;

		$pdf = new \FPDF('L','pt',array(550,830));
		$pdf->AddPage();
		
		//$img_template_data = explode(";",$row['sert_template']);
		$img_template = "sample_template.png";//$img_template_data[0];
		
		
		$pdf->Image('assets/img/template_certificate/'.$img_template,5,5,800,540);  //(kiri,atas,panjang,tinggi)
		
		$no_sertifikat = $course_id."-".$subtopic_id."-".session('userid'); // course_id-sub_topic-user_id
		$sert_id = $no_sertifikat;
		$nama = $row['nama'];
		$jenis_sertifikat = $row['sert_jenis'];
		
		$pdf->SetY(60);
		$pdf->Ln(78);
		$pdf->SetX(690);
		$pdf->SetFont('Arial', 'B', 18);
		
		$url_qr = url('certificate_verify')."/".$sert_id;
		$encodedmapsurl = urlencode($url_qr);
		$qr_name = "app/Lib/phpqrcode/temp/"."_".$sert_id.".png";
		\QRcode::png($encodedmapsurl,$qr_name);
		
		$pdf->Cell(750, 105, $pdf->Image($qr_name, $pdf->GetX(), 220,80,80),0,0,'R');// qr code
		$pdf->SetY(110);
		$pdf->Ln(57);
		$pdf->SetX(38);
		$pdf->SetFont('Arial', 'B', 10);
		//$pdf->Cell(750, 16, $no_sertifikat,0,0,'C');
		//Setting the text color to white
		if (strlen($nama) > 50) $pdf->SetFont('Arial', 'B', 18);
		else $pdf->SetFont('Arial', 'BI', 26);
		$pdf->Ln(20);
		$pdf->SetX(40);
		$pdf->Cell(750, 96, $nama,0,0,'C');
		
		$pdf->SetFont('Arial', '', 10);
		$pdf->Ln(110);
		$pdf->SetX(14);
		$pdf->Cell(750, 16, "Scan to Verify",0,0,'R');
		
		
		/*if (count($img_template_data) > 1) {
			$pdf->AddPage();
			$pdf->Image('assets/img/template_certificate/'.$img_template_data[1],5,5,800,540);  //(kiri,atas,panjang,tinggi)
		}*/
		
		//$pdf->Output();
		$fileName = $jenis_sertifikat.'-'.$nama. '.pdf';
		$pdf->Output($fileName, 'I'); // I for display. D for download
    }
}
