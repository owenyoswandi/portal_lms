<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_detail_profile;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class DetailProfileController extends Controller
{
    /**
    *    @OA\Get(
    *       path="/detail-profile",
    *       tags={"User"},
    *       operationId="listDetailProfile",
    *       summary="User - Get All",
    *       description="Mengambil Data Detail Profile",
	*		security={{ "bearerAuth": {} }},
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Detail Profile",
    *               "data": {
    *                   {
	*						"detail_id": "1",		
	*						"user_id": "2",
	*						"jenjang_pendidikan": "S1",
	*						"nama_institusi": "Binus University",
	*						"tahun_masuk": "2019",
	*						"tahun_lulus": "2021",
	*						"gelar": "S.Kom.",
	*						"bidang_studi": "Sistem Informasi",
	*						"nama_perusahaan": "Binus",
	*						"posisi": "Trainer",
	*						"periode_mulai": "2024-01-01",
	*						"periode_selesai": "2025-01-01",
	*						"tanggung_jawab": "Memberikan Pelatihan",
	*						"linkedin": "",
	*						"twitter": "",
	*						"instagram": "",
	*						"facebook": "",
	*						"github": "",
	*						"nama_keahlian": "Programmer",
	*						"sumber_keahlian": "BNSP",
	*						"sertifikasi": "Programmer",
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listDetailProfile() {
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Berhasil mengambil Data Detail Profile';
			$data = tbl_detail_profile::all();
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
    *       path="/detail-profile/{id}",
    *       tags={"User"},
    *       operationId="listDetailProfileById",
    *       summary="DetailProfile - Get By ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	 *     @OA\Schema(
	 *       default="2",
	 *       type="string",
	 *     ),
	 *     description="Masukan User Detail ID",
	 *     example="2",
	 *     in="path",
	 *     name="id",
	 *     required=true,
	 *   ),
    *       description="Mengambil Data User Berdasarkan ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data User",
    *               "data": {
    *                   {
	*						"detail_id": "1",		
	*						"user_id": "2",
	*						"jenjang_pendidikan": "S1",
	*						"nama_institusi": "Binus University",
	*						"tahun_masuk": "2019",
	*						"tahun_lulus": "2021",
	*						"gelar": "S.Kom.",
	*						"bidang_studi": "Sistem Informasi",
	*						"nama_perusahaan": "Binus",
	*						"posisi": "Trainer",
	*						"periode_mulai": "2024-01-01",
	*						"periode_selesai": "2025-01-01",
	*						"tanggung_jawab": "Memberikan Pelatihan",
	*						"linkedin": "",
	*						"twitter": "",
	*						"instagram": "",
	*						"facebook": "",
	*						"github": "",
	*						"nama_keahlian": "Programmer",
	*						"sumber_keahlian": "BNSP",
	*						"sertifikasi": "Programmer",
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listDetailProfileById($id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data DetailProfile';
				$data = tbl_detail_profile::where([
					['detail_id', '=', $id]
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
	*     	operationId="insertDetailProfile",
	*     	tags={"User"},
	*     	summary="detail-profile - Insert",
	*     	description="Post data Detail Profile",
	*     	path="/detail-profile/create",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*						"user_id": "2",
	*						"jenjang_pendidikan": "S1",
	*						"nama_institusi": "Binus University",
	*						"tahun_masuk": "2019",
	*						"tahun_lulus": "2021",
	*						"gelar": "S.Kom.",
	*						"bidang_studi": "Sistem Informasi",
	*						"nama_perusahaan": "Binus",
	*						"posisi": "Trainer",
	*						"periode_mulai": "2024-01-01",
	*						"periode_selesai": "2025-01-01",
	*						"tanggung_jawab": "Memberikan Pelatihan",
	*						"linkedin": "",
	*						"twitter": "",
	*						"instagram": "",
	*						"facebook": "",
	*						"github": "",
	*						"nama_keahlian": "Programmer",
	*						"sumber_keahlian": "BNSP",
	*						"sertifikasi": "Programmer",
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
	public function insertDetailProfile(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'user_id' => 'required'
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
			$result = tbl_detail_profile::create($request->all());
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
	*     	operationId="updateDetailProfile",
	*     	tags={"User"},
	*     	summary="DetailProfile - Update",
	*     	description="Update data DetailProfile",
	*     	path="/detail-profile/update",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*						"detail_id": "2",		
	*						"user_id": "2",
	*						"jenjang_pendidikan": "S1",
	*						"nama_institusi": "Binus University",
	*						"tahun_masuk": "2019",
	*						"tahun_lulus": "2021",
	*						"gelar": "S.Kom.",
	*						"bidang_studi": "Sistem Informasi",
	*						"nama_perusahaan": "Binus",
	*						"posisi": "Trainer",
	*						"periode_mulai": "2024-01-01",
	*						"periode_selesai": "2025-01-01",
	*						"tanggung_jawab": "Memberikan Pelatihan",
	*						"linkedin": "",
	*						"twitter": "",
	*						"instagram": "",
	*						"facebook": "",
	*						"github": "",
	*						"nama_keahlian": "Programmer",
	*						"sumber_keahlian": "BNSP",
	*						"sertifikasi": "Programmer",
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
	public function updateDetailProfile(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'detail_id' => 'required'
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
			
			$input = $request->all();
			$id = Arr::pull($input, 'detail_id', '');

			$result = tbl_detail_profile::find($id);
			// check data avail
			if ($result === null) {
				return response()->json([
					'success' => false,
					'message' => 'data tidak ditemukan',
					'data'    => [
						'detail_id' => $id
					]
				], 400);
			}

			// process
			$result->fill($input);
			$changed = $result->getDirty(); //get changed data [only updated data]
			$data = $result->save();
		}
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'    => $data  
		], 200);
    }
	
}
