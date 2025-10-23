<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\tbl_user;

/**
* @OA\Info(
*      version="1.0.0",
*      title="Dokumentasi API",
*      description="API Project Portal IAIS",
*      @OA\Contact(
*          email="ekoabdulgoffar129@gmail.com"
*      ),
*      @OA\License(
*          name="Apache 2.0",
*          url="http://www.apache.org/licenses/LICENSE-2.0.html"
*      )
* )
*
* @OA\SecurityScheme(
*         securityScheme="bearerAuth",
*         type="http",
*         scheme="bearer",
*         description="Enter token"
*  )
*
* @OA\Server(
*      url=L5_SWAGGER_CONST_HOST,
*      description="API Project Portal IAIS"
* )
*/

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function checkToken($token) {
		if ($token == null) $token = '';
		$data = tbl_user::where([
				['api_token', '=', $token]
			])->get();
		$result = false;
		if (!$data->isEmpty()) {
			$result = true;
		}
		return $result;
	}
}
