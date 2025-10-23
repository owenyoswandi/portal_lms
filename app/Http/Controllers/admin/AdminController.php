<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\rencana_kunjungan;
use App\Models\tbl_detail_profile_jwb;
use App\Models\tbl_user;
use App\Models\hasil_pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\tbl_group_member;

class AdminController extends Controller
{
    function index()
    {
        $data = [];

        return view('admin.users', $data);
    }

    function adminGroup()
    {
        $data = [];

        return view('admin.groups', $data);
    }
	
	function order(){
        $data = [];
        
        return view('admin/order', $data);
    }

    function topup(){
        $data = [];
        
        return view('admin/topup', $data);
    }

    function course(){
        $data = [];
        
        return view('admin/course', $data);
    }

    function view_course($id){        
        return view('admin/view_course', compact('id'));
    }

    function view_subtopic($p_id, $st_id){        
        return view('admin/view_subtopic', compact('p_id','st_id'));
    }

    function topic($id){        
        return view('admin/topic', compact('id'));
    }

    function subtopic($p_id, $t_id){        
        return view('admin/subtopic', compact('p_id','t_id'));
    }

    function grading($p_id, $st_id, $sm_id){        
        return view('admin/grading', compact('p_id','st_id','sm_id'));
    }
    
    function subtopic_test($p_id, $t_id, $st_id){        
        return view('admin/subtopic-test', compact('p_id','t_id','st_id'));
    }

    function downloadFile($folder, $filename){
        $file_path = public_path("$folder/$filename");
        return response()->download($file_path);
    }

    function project(){
        return view('admin/project');
    }

    function view_test($p_id, $st_id){        
        return view('admin/view_test', compact('p_id','st_id'));
    }
    
    function review($p_id, $st_id, $hasil_id){        
        return view('admin/review', compact('p_id','st_id', 'hasil_id'));
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
		
		
		$pdf->Image('public/assets/img/template_certificate/'.$img_template,5,5,800,540);  //(kiri,atas,panjang,tinggi)
		
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

    
    function group_courses($group_id){        
        return view('admin/group_courses', compact('group_id'));
    }

    function group_members($group_id){  
	
		if(isset($_GET['datauserid'])) {
			$datauserid = $_GET['datauserid'];
			
			$success = true;
			$message = 'Data berhasil diubah';
			$data = [];
			
			//menambahkan group	
			$arr_userid = explode(",",$datauserid);
			foreach ($arr_userid as $userid) {
			
				$datagm = array(
					"group_id"=>$group_id,
					"user_id"=>$userid
				);

				$gm = tbl_group_member::where('user_id', $userid)
                        ->first();
                        
                if($gm){
                    $gm->update($datagm);
                } else {
                    $gm = tbl_group_member::create([
                        'group_id' => $group_id,
                        'user_id' => $userid
                    ]);
                }
				
				array_push($data, $datagm);
			}
			
			return response()->json([
				'success' => $success,
				'message' => $message,
				'data'    => $data  
			], 200);
			
		} else {
			/*$datauser = tbl_user::select('*')
				->whereNotIn('user_id', function($query) use ($group_id) {
					$query->select('user_id')
						  ->from('tbl_group_member')
						  ->where('group_id', '=', $group_id);
				})
				->get();*/
			
			$datauser = tbl_user::select('*')
				->whereNotIn('user_id', function($query) {
					$query->select('user_id')
						  ->from('tbl_group_member');
						  // tidak ada filter group_id => semua grup terfilter
				})
				->get();
			
			return view('admin/group_members', compact('group_id', 'datauser'));
		}
		
		
    }
}
