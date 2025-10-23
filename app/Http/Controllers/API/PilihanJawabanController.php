<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_pilihan_jawaban;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class PilihanJawabanController extends Controller
{
	//------------------------------------------------------- Start Jawaban
    /**
    *    @OA\Get(
    *       path="/jawaban",
    *       tags={"Jawaban"},
    *       operationId="listJawaban",
    *       summary="Jawaban - Get All",
    *       description="Mengambil Data Jawaban",
	*		security={{ "bearerAuth": {} }},
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Jawaban",
    *               "data": {
    *                   {
	*					  "pilihan_id": 1,
	*					  "pertanyaan_id": 1,
	*					  "teks_pilihan": "Machine Learning",
	*					  "is_jawaban_benar": 1,
	*					  "maks_nilai": 10
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listJawaban() {
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Berhasil mengambil Data Jawaban';
			$data = tbl_pilihan_jawaban::All();
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
    *       path="/jawaban/{id}",
    *       tags={"Jawaban"},
    *       operationId="listJawabanById",
    *       summary="Jawaban - Get By  ID",
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
    *       description="Mengambil Data Jawaban Berdasarkan Jawaban ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data By Jawaban ID",
    *               "data": {
    *                   {
	*					  "pilihan_id": 1,
	*					  "pertanyaan_id": 1,
	*					  "teks_pilihan": "Machine Learning",
	*					  "is_jawaban_benar": 1,
	*					  "maks_nilai": 10
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listJawabanById($id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Jawaban';
				$data = tbl_pilihan_jawaban::
				where([
					['pilihan_id', '=', $id]
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
	*     	operationId="insertJawaban",
	*     	tags={"Jawaban"},
	*     	summary="Jawaban - Insert",
	*     	description="Post data Jawaban",
	*     	path="/jawaban/create",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*					  "pertanyaan_id": 1,
	*					  "teks_pilihan": "Machine Learning",
	*					  "is_jawaban_benar": 1,
	*					  "maks_nilai": 10
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
	public function insertJawaban(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'pertanyaan_id' => 'required',
			'teks_pilihan' => 'required',
			'is_jawaban_benar' => 'required',
			'maks_nilai' => 'required'
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
			$result = tbl_pilihan_jawaban::create($request->all());
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
	*     	operationId="updateJawaban",
	*     	tags={"Jawaban"},
	*     	summary="Jawaban - Update",
	*     	description="Update data Jawaban",
	*     	path="/jawaban/update",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*					  "pilihan_id": 1,
	*					  "pertanyaan_id": 1,
	*					  "teks_pilihan": "Machine Learning",
	*					  "is_jawaban_benar": 1,
	*					  "maks_nilai": 10
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
	public function updateJawaban(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'pilihan_id' => 'required',
			'pertanyaan_id' => 'required',
			'teks_pilihan' => 'required',
			'is_jawaban_benar' => 'required',
			'maks_nilai' => 'required'
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
			$id = Arr::pull($input, 'pilihan_id', '');

			$result = tbl_pilihan_jawaban::find($id);
			// check data avail
			if ($result === null) {
				return response()->json([
					'success' => false,
					'message' => 'data tidak ditemukan',
					'data'    => [
						'pilihan_id' => $id
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
	
	/**
     * 	@OA\Delete(
     *     	operationId="deleteJawaban",
     *     	tags={"Jawaban"},
     *     	summary="Jawaban - Delete",
     *     	description="Delete data Jawaban",
     *     	path="/jawaban/delete",
     *     	security={{"bearerAuth":{}}},
     *    	@OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *             example={
     *				"pertanyaan_id": "1",
     *             },
     *         ),
     *     	),
     *       @OA\Response(
     *           response="200",
     *           description="Ok",
     *           @OA\JsonContent
     *           (example={
     *				"success": true,
     *				"message": "Data berhasil dihapus",
     *				"data": {
     *  				"pilihan_id": "1",
     *				},
     *			}),
     *      ),
     * 	)
     *
     *
     */
    public function deleteJawaban(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            "pilihan_id"  => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $id = $request->input("pilihan_id");
        $result = tbl_pilihan_jawaban::find($id);
        // check data avail
        if ($result === null) {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan',
                'data'    => [
                    'pilihan_id' => $id
                ]
            ], 400);
        }

        $result = $result->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'data'    => [
                'pilihan_id' => $id
            ]
        ], 200);
    }
}
