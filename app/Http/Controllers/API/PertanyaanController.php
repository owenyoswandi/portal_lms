<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_pertanyaan;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class PertanyaanController extends Controller
{
	//------------------------------------------------------- Start Pertanyaan
    /**
    *    @OA\Get(
    *       path="/pertanyaan",
    *       tags={"Pertanyaan"},
    *       operationId="listPertanyaan",
    *       summary="Pertanyaan - Get All",
    *       description="Mengambil Data Pertanyaan",
	*		security={{ "bearerAuth": {} }},
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Pertanyaan",
    *               "data": {
    *                   {
	*					  "pertanyaan_id": 1,
	*					  "course_id": 1,
	*					  "kategori": "Pretest",
	*					  "teks_pertanyaan": "Pengolahan Data yang dikelola secara otomatis oleh mesin dan mempelajari semua pola sesuai dari data yang tersedia adalah",
	*					  "tipe_pertanyaan": "pilihan_ganda",
	*					  "p_judul": "Machine Learning"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listPertanyaan() {
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Berhasil mengambil Data Pertanyaan';
			$data = tbl_pertanyaan::join('tbl_product as p','tbl_pertanyaan.course_id','=','p.p_id')
				->select('tbl_pertanyaan.*','p.p_judul')
				->where([
					['p.p_jenis', '=', "course"]
				])->get();
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
    *       path="/pertanyaan/{id}",
    *       tags={"Pertanyaan"},
    *       operationId="listPertanyaanById",
    *       summary="Pertanyaan - Get By  ID",
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
    *       description="Mengambil Data Pertanyaan Berdasarkan Pertanyaan ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Notifikasi By Pertanyaan ID",
    *               "data": {
    *                   {
	*					  "pertanyaan_id": 1,
	*					  "course_id": 1,
	*					  "kategori": "Pretest",
	*					  "teks_pertanyaan": "Pengolahan Data yang dikelola secara otomatis oleh mesin dan mempelajari semua pola sesuai dari data yang tersedia adalah",
	*					  "tipe_pertanyaan": "pilihan_ganda",
	*					  "p_judul": "Machine Learning"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listPertanyaanById($id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Pertanyaan';
				$data = tbl_pertanyaan::join('tbl_product as p','tbl_pertanyaan.course_id','=','p.p_id')
				->select('tbl_pertanyaan.*','p.p_judul')
				->where([
					['p.p_jenis', '=', "course"],
					['tbl_pertanyaan.pertanyaan_id', '=', $id]
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
	*     	operationId="insertPertanyaan",
	*     	tags={"Pertanyaan"},
	*     	summary="Pertanyaan - Insert",
	*     	description="Post data Pertanyaan",
	*     	path="/pertanyaan/create",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*					  "course_id": 1,
	*					  "kategori": "Pretest",
	*					  "teks_pertanyaan": "Pengolahan Data yang dikelola secara otomatis oleh mesin dan mempelajari semua pola sesuai dari data yang tersedia adalah",
	*					  "tipe_pertanyaan": "pilihan_ganda",
	*					  "maks_nilai": "5"
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
	public function insertPertanyaan(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'course_id' => 'required',
			'teks_pertanyaan' => 'required',
			'tipe_pertanyaan' => 'required'
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
			$result = tbl_pertanyaan::create($request->all());
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
	*     	operationId="updatePertanyaan",
	*     	tags={"Pertanyaan"},
	*     	summary="Pertanyaan - Update",
	*     	description="Update data Pertanyaan",
	*     	path="/pertanyaan/update",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*					  "pertanyaan_id": 1,
	*					  "course_id": 1,
	*					  "kategori": "Pretest",
	*					  "teks_pertanyaan": "Pengolahan Data yang dikelola secara otomatis oleh mesin dan mempelajari semua pola sesuai dari data yang tersedia adalah",
	*					  "tipe_pertanyaan": "pilihan_ganda",
	*					  "maks_nilai": "5"
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
	public function updatePertanyaan(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
			'course_id' => 'required',
			'teks_pertanyaan' => 'required',
			'tipe_pertanyaan' => 'required'
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
			$id = Arr::pull($input, 'pertanyaan_id', '');

			$result = tbl_pertanyaan::find($id);
			// check data avail
			if ($result === null) {
				return response()->json([
					'success' => false,
					'message' => 'data tidak ditemukan',
					'data'    => [
						'pertanyaan_id' => $id
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
     *     	operationId="deletePertanyaan",
     *     	tags={"Pertanyaan"},
     *     	summary="Pertanyaan - Delete",
     *     	description="Delete data Pertanyaan",
     *     	path="/pertanyaan/delete",
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
     *  				"pertanyaan_id": "1",
     *				},
     *			}),
     *      ),
     * 	)
     *
     *
     */
    public function deletePertanyaan(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            "pertanyaan_id"  => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $id = $request->input("pertanyaan_id");
        $result = tbl_pertanyaan::find($id);
        // check data avail
        if ($result === null) {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan',
                'data'    => [
                    'pertanyaan_id' => $id
                ]
            ], 400);
        }

        $result = $result->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'data'    => [
                'pertanyaan_id' => $id
            ]
        ], 200);
    }
	
	/**
    *    @OA\Get(
    *       path="/pertanyaan-jawaban/{id}",
    *       tags={"Pertanyaan"},
    *       operationId="listPertanyaanJawabanByCourseId",
    *       summary="Pertanyaan Jawaban - Get All",
	*		security={{ "bearerAuth": {} }},
    *       description="Mengambil Data Jawaban Berdasarkan Pertanyaan Jawaban ",
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
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Pertanyaan Jawaban",
    *               "data": {
    *                   {
	*					  "pertanyaan_id": 1,
	*					  "course_id": 1,
	*					  "kategori": "Pretest",
	*					  "teks_pertanyaan": "Pengolahan Data yang dikelola secara otomatis oleh mesin dan mempelajari semua pola sesuai dari data yang tersedia adalah",
	*					  "tipe_pertanyaan": "pilihan_ganda"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listPertanyaanJawabanByCourseId($id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Pertanyaan';
				$data = tbl_pertanyaan::join('tbl_pilihan_jawaban as jwb','tbl_pertanyaan.pertanyaan_id','=','jwb.pertanyaan_id')
				->select('*')
				->where([
					['tbl_pertanyaan.pertanyaan_id', '=', $id]
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
