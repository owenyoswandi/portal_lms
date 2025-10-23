<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MemberCardController extends Controller
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
        
        //return view('membercard', $data);
    }
	
	function membercard($group, $memberid, $position, $expired, $email, $nohp, $web ,$name){
		require('app/fpdf186/html2pdf.php');

		$pdf=new \PDF_HTML();
		$pdf->SetFont('Arial','',12);
		
		$fpdf_width = 230;
		$fpdf_height = 130;
		
        $pdf->AddPage("L", [$fpdf_width, $fpdf_height]);
            
		// put the image in first order
		$pdf->Image(asset("/public/img/bg_membercard.png"), 0, 0, $fpdf_width, $fpdf_height);
		$pdf->Image(asset("/public/img/logo_iais.png"), 10, 10, 50, 20); //kiri-kanan, atas/bawah, panjang, lebar
		
		
		$url_qr = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$pdf->Image('https://quickchart.io/qr?text='.$url_qr .'&size=15', 10, 38, 30, 30, 'PNG');
		
		$pdf->SetFont('Arial', 'B', 18); 
		$pdf->Cell( 220, 10, $group, 0, 0, 'C' ); 
		$pdf->SetFont('Arial', 'B', 18);
		//$pdf->Cell( -220, 28, $group, 0, 0, 'C' );  
		//$pdf->SetFont('Arial', 'B', 20);
		$pdf->SetX(46); 
		$pdf->Cell( 160, 70, $name, 0, 0, 'L' ); 
		
		$pdf->SetDrawColor(245, 55, 42);
		$pdf->SetLineWidth(0.7);
		$pdf->Line(47, 53, 210, 53);
        
		$pdf->Ln(13);
		$pdf->SetFont('Arial', 'I', 18); 
		$pdf->SetX(46); 
		$pdf->Cell( 110, 76, $position, 0, 0, 'L' ); 
		
		$pdf->Ln(55);
		$pdf->SetFont('Arial', '', 14); 
		$pdf->SetX(10); 
		$pdf->MultiCell( 89, 7, "Member ID\t\t: ".$memberid, 2);
		
		$pdf->Ln(1);
		$pdf->SetFont('Arial', '', 14); 
		$pdf->SetX(10); 
		$pdf->MultiCell( 89, 7, "Whats App\t\t: ".$nohp, 2);
		
		$pdf->Ln(1);
		$pdf->SetFont('Arial', '', 14); 
		$pdf->SetX(10); 
		$pdf->MultiCell( 149, 7, "Email\t\t\t\t\t\t\t\t\t\t\t: ".$email, 2);
		
		$pdf->Ln(1);
		$pdf->SetFont('Arial', '', 14); 
		$pdf->SetX(10); 
		$pdf->MultiCell( 89, 7, "Expired\t\t\t\t\t\t\t\t: ".$expired, 2);
		
		
		$pdf->SetFont('Arial', '', 8); 
		//move pionter at the bottom of the page 
        $pdf->SetY(-20);
		//set font color to blue 
		$pdf->SetTextColor( 52, 98, 185 ); 
		$pdf->Cell( 0, -1, '', 0, 0, 'L' ); 
		//set font color to gray 
		$pdf->SetTextColor( 150, 150, 150 ); 
		//write Page No 
		$pdf->Cell( 0, -1, $web, 0, 0, 'R' );
		
		//$pdf->Output();
		$fileName = $memberid ."_". $name . '.pdf';
		$pdf->Output($fileName, 'I');
		
		exit;
        //return $memberid."-".$name."-".$position."-".$expired;
    }

}
