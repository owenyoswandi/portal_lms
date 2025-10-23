<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_order;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
    *    @OA\Get(
    *       path="/order",
    *       tags={"Order"},
    *       operationId="listOrder",
    *       summary="Order - Get All",
    *       description="Mengambil Data Order",
	*		security={{ "bearerAuth": {} }},
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Order",
    *               "data": {
    *                   {
    *						"or_id": 1,
    *						"p_id": 4,
    *						"user_id": 11,
    *						"or_status": 1,
    *						"or_created_date": "2024-03-12",
    *						"or_modified_date": "2024-03-12"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listOrder() {
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Berhasil mengambil Data Order';
			$data = tbl_order::select("*")
                                ->join('tbl_user', 'tbl_order.user_id', '=', 'tbl_user.user_id')
                                ->join('tbl_product', 'tbl_order.p_id', '=', 'tbl_product.p_id')
                                ->orderBy("tbl_order.user_id", "asc")
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
    *       path="/order/{id}",
    *       tags={"Order"},
    *       operationId="listOrderById",
    *       summary="Order - Get By ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID",
	*     example="1",
	*     in="path",
	*     name="or_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Order Berdasarkan ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Order",
    *               "data": {
    *                   {
    *						"or_id": "1",
    *						"p_id": "4",
    *						"title": "NLP",
    *						"user_id": "EMAS2074",
    *						"or_status": "0",
    *						"or_created_date": "2024-03-23",
    *						"or_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listOrderById($id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Order';
				$data = tbl_order::where([
					['id', '=', $id]
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
    *    @OA\Get(
    *       path="/order-byuserid/{user_id}",
    *       tags={"Order"},
    *       operationId="listOrderByUserID",
    *       summary="Order - Get By User ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan User ID",
	*     example="11",
	*     in="path",
	*     name="user_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Order Berdasarkan User ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Order",
    *               "data": {
    *                   {
    *						"or_id": 1,
    *						"p_id": 4,
    *						"user_id": 11,
    *						"or_status": 1,
    *						"or_created_date": "2024-03-12",
    *						"or_modified_date": "2024-03-12"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listOrderByUserID($user_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;

            $status = 1; // sudah acc admin
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Order';
				$data = tbl_order::select("*")
                ->join('tbl_product', 'tbl_order.p_id', '=', 'tbl_product.p_id')
                ->where([
					['user_id', '=', $user_id]
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
    *    @OA\Get(
    *       path="/order-bycourseid/{p_id_lms}/{user_id}",
    *       tags={"Order"},
    *       operationId="getOrderByCourseId",
    *       summary="Order - Get By Course ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID",
	*     example="4",
	*     in="path",
	*     name="p_id_lms",
	*     required=true,
	*   ),
    *   @OA\Parameter(
	*     @OA\Schema(
	*       default="11",
	*       type="string",
	*     ),
	*     description="Masukan user_id",
	*     example="11",
	*     in="path",
	*     name="user_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Order Berdasarkan Course ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Order",
    *               "data": {
    *                   {
    *						"or_id": "1",
    *						"p_id": "4",
    *						"title": "NLP",
    *						"user_id": "EMAS2074",
    *						"or_status": "0",
    *						"or_created_date": "2024-03-23",
    *						"or_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */

    public function getOrderByCourseId($p_id_lms, $user_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			// if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Order';
                $data = tbl_order::select("*")
                ->join('tbl_product', 'tbl_order.p_id', '=', 'tbl_product.p_id')
                ->where([
                    ['p_id_lms', '=', $p_id_lms],
					['user_id', '=', $user_id]
				])->first();
			// }
			
			//make response JSON
			return response()->json([
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
	*     	operationId="insertOrder",
	*     	tags={"Order"},
	*     	summary="Order - Insert",
	*     	description="Post data Order",
	*     	path="/order/create",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
    *						"or_id": "1",
    *						"p_id": "4",
    *						"title": "NLP",
    *						"user_id": "EMAS2074",
    *						"or_status": "0",
    *						"or_created_date": "2024-03-23",
    *						"or_modified_date": null
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
	public function insertOrder(Request $request) {		
		//define validation rules
        $validator = Validator::make($request->all(), [
            'p_id' => 'required',
            'p_harga' => 'required',
            'user_id' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $success = true;
        $message = 'Data berhasil disimpan';
        $result = tbl_order::create($request->all());
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'    => $result  
		], 201);
    }
    
    /**
	* 	@OA\Put(
	*     	operationId="updateOrder",
	*     	tags={"Order"},
	*     	summary="Order - Update",
	*     	description="Update data Order",
	*     	path="/order/update",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
    *						"or_id": "1",
    *						"p_id": "4",
    *						"title": "NLP",
    *						"user_id": "EMAS2074",
    *						"or_status": "0",
    *						"or_created_date": "2024-03-23",
    *						"or_modified_date": null
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
	public function updateOrder(Request $request) {
		
		//define validation rules
        $validator = Validator::make($request->all(), [
            'id' => 'required'
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
                "or_status"=>$request->input("status"),
                "or_modified_date"=>$request->input("modidate")
			);
			
			$id = $request->input("or_id");
			$result = tbl_order::where([
					['id', '=', $id]
				])->update($data);
		}
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'    => $data  
		], 200);
    }

}
