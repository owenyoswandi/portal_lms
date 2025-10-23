<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_user;
use App\Models\tbl_group_member;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
    *    @OA\Get(
    *       path="/user",
    *       tags={"User"},
    *       operationId="listUser",
    *       summary="User - Get All",
    *       description="Mengambil Data User",
	*		security={{ "bearerAuth": {} }},
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data User",
    *               "data": {
    *                   {
	*						"user_id": "ekoag",
	*						"username": "ekoag",
	*						"password": "ekoag",
	*						"nama": "Eko",
	*						"alamat": "Sukabumi",
	*						"no_hp": "085333461216",
	*						"email": "eko@gmail.com",
	*						"jk": "Laki-laki",
	*						"tgl_lhr": "1997-02-15",
	*						"role": "Admin",
	*						"provinsi": "JAWA BARAT"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listUser() {
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Berhasil mengambil Data User';
			$data = tbl_user::all();
		}
		
		//make response JSON
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data  
        ], 200);
    }


	public function userSelect() {
		 $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;
       
        if ($this->checkToken($token)) {
            $success = true;
            $message = 'Berhasil mengambil Data User';
            $data = tbl_user::where('role','!=', 'Admin')
                           ->select('user_id', 'nama','username', 'email', 'role', 'created_at', 'updated_at')
                           ->get();
        }
		
		//make response JSON
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data  
        ], 200);
    }

	/**
    *    @OA\Get(
    *       path="/user/{id}",
    *       tags={"User"},
    *       operationId="listUserById",
    *       summary="User - Get By ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	 *     @OA\Schema(
	 *       default="ekoag",
	 *       type="string",
	 *     ),
	 *     description="Masukan Username",
	 *     example="ekoag",
	 *     in="path",
	 *     name="id",
	 *     required=true,
	 *   ),
    *       description="Mengambil Data User Berdasarkan Username",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data User",
    *               "data": {
    *                   {
	*						"user_id": "ekoag",
	*						"username": "ekoag",
	*						"password": "ekoag",
	*						"nama": "Eko",
	*						"alamat": "Sukabumi",
	*						"no_hp": "085333461216",
	*						"email": "eko@gmail.com",
	*						"jk": "Laki-laki",
	*						"tgl_lhr": "1997-02-15",
	*						"role": "Admin",
	*						"provinsi": "JAWA BARAT"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listUserById($id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data User';
				$data = tbl_user::leftjoin('tbl_group_member', 'tbl_user.user_id', '=', 'tbl_group_member.user_id')
				->where([
					['username', '=', $id]
				])->select('tbl_user.*','tbl_group_member.group_id')
				->get();
			}
			
			//make response JSON
			return response()->json([
				'success' => $success,
				'message' => $message,
				'data'    => $data  
			], 200);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }
	
	/**
	* 	@OA\Post(
	*     	operationId="insertUser",
	*     	tags={"User"},
	*     	summary="User - Insert",
	*     	description="Post data User",
	*     	path="/user/create",
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
	*						"email": "eko@gmail.com",
	*						"jk": "Laki-laki",
	*						"tgl_lhr": "1997-02-15",
	*						"role": "Dokter",
	*						"provinsi": "JAWA BARAT"
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
	public function insertUser(Request $request) {
		
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

		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Data berhasil disimpan';
			$result = tbl_user::create($request->all());
		}
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'    => $data  
		], 201);
    }
	
	/**
	* 	@OA\Put(
	*     	operationId="updateUser",
	*     	tags={"User"},
	*     	summary="User - Update",
	*     	description="Update data User",
	*     	path="/user/update",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*						"username": "ekoag",
	*						"nama": "Eko ABdul Goffar",
	*						"alamat": "Sukabumi",
	*						"no_hp": "085333461216",
	*						"email": "eko@gmail.com",
	*						"jk": "Laki-laki",
	*						"tgl_lhr": "1997-02-15",
	*						"role": "Dokter",
	*						"provinsi": "JAWA BARAT",
	*						"kelurahan": "",
	*						"kecamatan": "",
	*						"kota_kab": "",
	*						"pendidikan": "",
	*						"pekerjaan": "",
	*						"agama": "",
	*						"nik": ""
    *             },
    *         ),
    *     	),
	*       @OA\Response(
    *           response="201",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
	*				"success": true,
	*				"message": "Data berhasil diubah"
	*			}),
    *      ),
	 * 	)
	 *
	*
	*/
	public function updateUser(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'nama' => 'required',
			'alamat' => 'required',
			'no_hp' => 'required',
			'jk' => 'required',
			'tgl_lhr' => 'required',
			'role' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Data berhasil diubah';
			
			$data = array(
				"nama"=>$request->input("nama"),
				"alamat"=>$request->input("alamat"),
				"no_hp"=>$request->input("no_hp"),
				'email' => $request->input("email"),
				"jk"=>$request->input("jk"),
				"tgl_lhr"=>$request->input("tgl_lhr"),
				"role"=>$request->input("role"),
				"provinsi"=>$request->input("provinsi"),
				"kelurahan"=>$request->input("kelurahan"),
				"kecamatan"=>$request->input("kecamatan"),
				"kota_kab"=>$request->input("kota_kab"),
				"pendidikan"=>$request->input("pendidikan"),
				"pekerjaan"=>$request->input("pekerjaan"),
				"agama"=>$request->input("agama"),
				"nik"=>$request->input("nik")
			);
			if($request->input('password')){
				$data["password"] = $request->input('password');
			}
			
			$id = $request->input("username");
			$result = tbl_user::where([
					['username', '=', $id]
				])->update($data);

			//menambahkan group	
			if($request->input("group_id")){
				$datagm = array(
					"group_id"=>$request->input("group_id"),
					"user_id"=>$request->input("user_id")
				);

				// $gm = tbl_group_member::where('group_id', $request->input("group_id"))
                //         ->where('user_id', $request->user_id)
                //         ->first();

				$gm = tbl_group_member::where('user_id', $request->user_id)
                        ->first();
                        
                if($gm){
                    $gm->update($datagm);
                } else {
                    $gm = tbl_group_member::create([
                        'group_id' => $request->group_id,
                        'user_id' => $request->user_id
                    ]);
                }
			}
		}
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'    => $data  
		], 200);
    }
	
	/**
	* 	@OA\Delete(
	*     	operationId="deleteUser",
	*     	tags={"User"},
	*     	summary="User - Delete",
	*     	description="Delete data User",
	*     	path="/user/delete",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*				"username": "ekoag",
    *             },
    *         ),
    *     	),
	*       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
	*				"success": true,
	*				"message": "Data berhasil dihapus"
	*			}),
    *      ),
	 * 	)
	 *
	*
	*/
	public function deleteUser(Request $request) {
		//define validation rules
        $validator = Validator::make($request->all(), [
			  "username"     => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Data berhasil dihapus';
			
			$id = $request->input("username");
			$result = tbl_user::where([
					['username', '=', $id]
				])->delete();
			$data = $result;
		}
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data' => $data
		], 200);
    }
	
	/**
	* 	@OA\Put(
	*     	operationId="updatePassword",
	*     	tags={"User"},
	*     	summary="User - Change Password",
	*     	description="Change Password",
	*     	path="/user/changepassword",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*						"username": "ekoag",
	*						"password": "123"
    *             },
    *         ),
    *     	),
	*       @OA\Response(
    *           response="201",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
	*				"success": true,
	*				"message": "Password berhasil diubah"
	*			}),
    *      ),
	 * 	)
	 *
	*
	*/
	public function updatePassword(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'username' => 'required',
			'password' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
		
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Data berhasil diubah';
			
			$data = array(
				"username"=>$request->input("username"),
				"password"=>$request->input("password")
			);
			
			$id = $request->input("username");
			$result = tbl_user::where([
					['username', '=', $id]
				])->update($data);
		}
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'    => $data  
		], 200);
    }
	
	/**
    *    @OA\Get(
    *       path="/user-role/{role}",
    *       tags={"User"},
    *       operationId="listUserByRole",
    *       summary="User - Get By Role",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	 *     @OA\Schema(
	 *       default="ekoag",
	 *       type="string",
	 *     ),
	 *     description="Masukan Role",
	 *     example="Pasien",
	 *     in="path",
	 *     name="role",
	 *     required=true,
	 *   ),
    *       description="Mengambil Data User Berdasarkan Role",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data User",
    *               "data": {
    *                   {
	*						"user_id": "ekoag",
	*						"username": "ekoag",
	*						"password": "ekoag",
	*						"nama": "Eko",
	*						"alamat": "Sukabumi",
	*						"no_hp": "085333461216",
	*						"email": "eko@gmail.com",
	*						"jk": "Laki-laki",
	*						"tgl_lhr": "1997-02-15",
	*						"role": "Admin"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listUserByRole($role) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data User';
				$data = tbl_user::where([
					['role', '=', $role]
				])->get();
			}
			
			//make response JSON
			return response()->json([
				'success' => $success,
				'message' => $message,
				'data'    => $data  
			], 200);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }
}
