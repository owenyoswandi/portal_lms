<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\notifikasi;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class NotifikasiController extends Controller
{
	//------------------------------------------------------- Start Notifikasi
    /**
    *    @OA\Get(
    *       path="/notifikasi",
    *       tags={"Notifikasi"},
    *       operationId="listNotifikasi",
    *       summary="Notifikasi - Get All",
    *       description="Mengambil Data Notifikasi",
	*		security={{ "bearerAuth": {} }},
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Notifikasi",
    *               "data": {
    *                   {
	*					  "not_id": 1,
	*					  "not_userid": 19,
	*					  "not_deskripsi": "Terdapat pasisen yang telat minum air atas nama kiki13",
	*					  "not_statusbaca": 0,
	*					  "not_created": "2024-01-27 00:00:00",
	*					  "not_modified": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listNotifikasi() {
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Berhasil mengambil Data Notifikasi';
			$data = notifikasi::All();
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
    *       path="/notifikasi-byuserid/{id}",
    *       tags={"Notifikasi"},
    *       operationId="listNotifikasiByUserId",
    *       summary="Notifikasi - Get By User ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	 *     @OA\Schema(
	 *       default="1",
	 *       type="string",
	 *     ),
	 *     description="Masukan ID",
	 *     example="1",
	 *     in="path",
	 *     name="id",
	 *     required=true,
	 *   ),
    *       description="Mengambil Data Notifikasi Berdasarkan User ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Notifikasi By User ID",
    *               "data": {
    *                   {
	*					  "not_id": 1,
	*					  "not_userid": 19,
	*					  "not_deskripsi": "Terdapat pasisen yang telat minum air atas nama kiki13",
	*					  "not_statusbaca": 0,
	*					  "not_created": "2024-01-27 00:00:00",
	*					  "not_modified": null,
	*					  "user_nama": "Eko ABdul Goffar"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listNotifikasiByUserId($id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Notifikasi';
				$data = notifikasi::join('tbl_user as u','u.user_id','=','notifikasi.not_userid')
				->select('notifikasi.*','u.nama as user_nama')
				->where([
					['notifikasi.not_userid', '=', $id]
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
	
	/**
	* 	@OA\Post(
	*     	operationId="insertNotifikasi",
	*     	tags={"Notifikasi"},
	*     	summary="Notifikasi - Insert",
	*     	description="Post data Notifikasi",
	*     	path="/notifikasi/create",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*					  "not_userid": 19,
	*					  "not_deskripsi": "Terdapat pasisen yang telat minum air atas nama kiki13",
	*					  "not_statusbaca": 0,
	*					  "not_created": "2024-01-27 00:00:00",
	*					  "not_modified": null,
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
	public function insertNotifikasi(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'not_userid' => 'required',
			'not_deskripsi' => 'required',
			'not_statusbaca' => 'required',
			'not_created' => 'required',
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
			$result = notifikasi::create($request->all());
			$data = $result;
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
	*     	operationId="updateNotifikasiStatus",
	*     	tags={"Notifikasi"},
	*     	summary="Notifikasi - Update Status",
	*     	description="Update data Notifikasi",
	*     	path="/notifikasi/updatestatus",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*					  "not_id": 2,
	*					  "not_statusbaca": 1,
	*					  "not_modified": "2024-01-27 01:00:00"
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
	public function updateNotifikasiStatus(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'not_id' => 'required',
			'not_statusbaca' => 'required',
			'not_modified' => 'required'
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
				"not_statusbaca"=>$request->input("not_statusbaca"),
				"not_modified"=>$request->input("not_modified")
			);
			
			$id = $request->input("not_id");
			$result = notifikasi::where([
					['not_id', '=', $id]
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
	* 	@OA\Put(
	*     	operationId="updateNotifikasiStatusByUserId",
	*     	tags={"Notifikasi"},
	*     	summary="Notifikasi - Update Status All By User ID",
	*     	description="Update data Notifikasi",
	*     	path="/notifikasi/updatestatusbyuserid",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*					  "not_userid": 2,
	*					  "not_statusbaca": 1
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
	public function updateNotifikasiStatusByUserId(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'not_userid' => 'required',
			'not_statusbaca' => 'required'
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
			
			$mydata = array(
				"not_statusbaca"=>$request->input("not_statusbaca")
			);
			
			$id = $request->input("not_userid");
			$result = notifikasi::where([
					['not_userid', '=', $id]
				])->update($mydata);
			$data = $result;
		}
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'    => $data  
		], 200);
    }
}
