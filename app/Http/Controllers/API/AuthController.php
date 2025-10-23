<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_user;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{

	/**
	 * 	@OA\Post(
	 *     	operationId="checkLogin",
	 *     	tags={"Authentication"},
	 *     	summary="Authentication - Check Login",
	 *     	description="Authentication User",
	 *     	path="/auth/checkLogin",
	 *     	security={{"bearerAuth":{}}},
	 *    	@OA\RequestBody(
	 *         required=true,
	 *         description="Request Body Description",
	 *         @OA\JsonContent(
	 *             example={
	 *						"username": "admin",
	 *						"password": "admin"
	 *             },
	 *         ),
	 *     	),
	 *       @OA\Response(
	 *           response="201",
	 *           description="Ok",
	 *           @OA\JsonContent
	 *           (example={
	 *				"success": true,
	 *				"message": "Berhasil Login",
	 *               "data": {
	 *                   {
	 *						"username": "sa",
	 *						"nama": "Super Administrator",
	 *						"role": "Admin",
	 *					}
	 *				}
	 *			}),
	 *      ),
	 * 	)
	 *
	 *
	 */
	public function checkLogin(Request $request)
	{
		date_default_timezone_set('Asia/Jakarta');

		//define validation rules
		$validator = Validator::make($request->all(), [
			'username' => 'required',
			'password' => 'required',
		]);

		//check if validation fails
		if ($validator->fails()) {
			return response()->json($validator->errors(), 422);
		}

		$username = $request->input("username");
		$password = $request->input("password");

		// update token
		$token = $this->createToken();

		$data_update = array(
			"api_token" => $token,
			"updated_at" => date('Y-m-d H:i:s')
		);

		$result_update = tbl_user::where([
			['username', '=', $username],
			['password', '=', $password]
		])->update($data_update);

		$result = true;
		$message = "";

		if ($result_update != null) {
			$data = tbl_user::select('user_id','username', 'nama', 'role', 'updated_at', 'api_token', 'token_type')
				->where([
					['username', '=', $username],
					['password', '=', $password]
				])->get();


			if (!$data->isEmpty()) {
				$result = true;
				$message = "Login berhasil";
			} else {
				$result = false;
				$message = "Username atau password salah";
				$data = null;
			}
		} else {
			$result = false;
			$message = "Gagal create token";
			$data = null;
		}

		return response()->json([
			'success' => $result,
			'message' => $message,
			'data'    => $data
		], 201);
	}

	/**
	 * 	@OA\Post(
	 *     	operationId="register",
	 *     	tags={"Authentication"},
	 *     	summary="Authentication - Register",
	 *     	description="Post data Register",
	 *     	path="/auth/register",
	 *     	security={{"bearerAuth":{}}},
	 *    	@OA\RequestBody(
	 *         required=true,
	 *         description="Request Body Description",
	 *         @OA\JsonContent(
	 *             example={
	 *						"username": "ekoag",
	 *						"password": "ekoag",
	 *						"nama": "Eko ABdul Goffar",
	 *						"alamat": "Sukabumi",
	 *						"no_hp": "085333461216",
	 *						"email": "abc@gmail.com",
	 *						"jk": "Laki-laki",
	 *						"tgl_lhr": "1997-02-15",
	 *						"role": "Dokter",
	 * 						"rumah_sakit":null
	 *             },
	 *         ),
	 *     	),
	 *       @OA\Response(
	 *           response="201",
	 *           description="Ok",
	 *           @OA\JsonContent
	 *           (example={
	 *				"success": true,
	 *				"message": "Data berhasil disimpan"
	 *			}),
	 *      ),
	 * 	)
	 *
	 *
	 */
	public function register(Request $request)
	{

		//define validation rules
		$validator = Validator::make($request->all(), [
			'username' => 'required',
			'password' => 'required',
			'nama' => 'required',
			'alamat' => 'required',
			'no_hp' => 'required',
			'email' => 'required',
			'jk' => 'required',
			'tgl_lhr' => 'required',
			'role' => 'required'
		]);

		//check if validation fails
		if ($validator->fails()) {
			return response()->json($validator->errors(), 422);
		}

		$success = true;
		$message = 'Data berhasil disimpan';
		$result = tbl_user::create($request->all());

		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'    => $result
		], 201);
	}

	protected function createToken(): string
	{
		return hash('sha256', Str::random(20) . strtotime('now'));
	}
}
