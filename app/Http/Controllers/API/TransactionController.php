<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_transaction;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{

    /**
	* 	@OA\Post(
	*     	operationId="insertOrderCourse",
	*     	tags={"Transaction"},
	*     	summary="Transaction - Insert Transaction",
	*     	description="Post data Transaction",
	*     	path="/transaction/create-ordercourse",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
    *						"t_transaction_id": "TRANS123",
    *						"t_code": "102",
    *						"t_user_id": "11",
    *						"t_p_id": "1",
    *						"t_type": "inflow",
    *						"t_amount": 20000,
    *						"t_status": "unpaid",
    *						"t_created_date": "2024-03-12"
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
	public function insertOrderCourse(Request $request) {
        //define validation rules
        $validator = Validator::make($request->all(), [
            't_user_id' => 'required',
            't_amount' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = tbl_transaction::select('t_id', 't_code', 't_amount', 't_type')->where([
            ['t_user_id', $request->input("t_user_id")],
            ['t_status', '=', 'paid']
        ])->get();

        $balance = 0; 
        foreach ($data as $tr) {
            if($tr['t_type']=='inflow'){
                $balance += $tr['t_amount'];
            } else {
                $balance -= $tr['t_amount'];
            }
        }

        $success = false;
        $message = "Failed";
        $result = null;

        if($request->input("t_amount")>$balance){
            $success = false;
            $message = "insufficient balance";
            $result = null;
        } else {
            $data = array(
                "t_p_id"=>$request->input("t_p_id"),
               // "t_code"=>$request->input("t_code"),
                "t_user_id"=>$request->input("t_user_id"),
                "t_type"=>$request->input("t_type"),
                "t_amount"=>$request->input("t_amount"),
                "t_status"=>$request->input("t_status")
            );
    
            // if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil disimpan';
                $result = tbl_transaction::create($data);
            // }
        }
        // $token = request()->bearerToken();
        
        

        //make response JSON
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $result
        ], 201);
		
    }
    /**
	* 	@OA\Post(
	*     	operationId="insertTopUp",
	*     	tags={"Transaction"},
	*     	summary="Transaction - Insert Top Up",
	*     	description="Post data Transaction",
	*     	path="/transaction/create-topup",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
    *						"t_transaction_id": "TRANS123",
    *						"t_code": "101",
    *						"t_user_id": "11",
    *						"t_p_id": null,
    *						"t_type": "inflow",
    *						"t_amount": 20000,
    *						"t_status": "unpaid",
    *						"t_created_date": "2024-03-12"
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
	public function insertTopUp(Request $request) {
        //define validation rules
        $validator = Validator::make($request->all(), [
            't_code' => 'required',
            't_user_id' => 'required',
            't_amount' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $lastTopUp = tbl_transaction::select('t_id', 't_created_date', 't_amount', 't_status')->where([
            ['t_user_id', $request->input("t_user_id")],
            ['t_status', 'unpaid'], // Match status exactly against 'unpaid'
        ])->first();

        $success = false;
        $message = "Failed";
        $result = null;

        if($lastTopUp == null){
            // $token = request()->bearerToken();
            
            $data = array(
                "t_code"=>$request->input("t_code"),
                "t_user_id"=>$request->input("t_user_id"),
                "t_type"=>$request->input("t_type"),
                "t_amount"=>$request->input("t_amount"),
                "t_status"=>$request->input("t_status")
            );

            // if ($this->checkToken($token)) {
                $success = true;
                $message = 'Data berhasil disimpan';
                $result = tbl_transaction::create($data);
            // }
        } else {
            $success = False;
            $message = 'Top Up gagal dilakukan';
        }

        //make response JSON
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $result
        ], 201);
		
    }
    
    
    /**
    *    @OA\Get(
    *       path="/transaction-topup-byuserid/{user_id}",
    *       tags={"Transaction"},
    *       operationId="lastTopUpByUserID",
    *       summary="Transaction - Get Top Up By User ID",
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
    *       description="Mengambil Data Transaction Berdasarkan User ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Transaction",
    *               "data": {
    *                   {
    *						"t_id": "1",
    *						"t_transaction_id": "TRANS123",
    *						"t_code": "101",
    *						"t_user_id": "11",
    *						"t_p_id": null,
    *						"t_type": "inflow",
    *						"t_amount": 20000,
    *						"t_status": "unpaid",
    *						"t_user_proof": "user.jpg",
    *						"t_admin_proof": "admin.jpg",
    *						"t_created_date": "2024-03-12",
    *						"t_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function lastTopUpByUserID($user_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;

            $status = 1; // sudah acc admin
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Transaction';
				$data = tbl_transaction::select('t_id', 't_created_date', 't_amount', 't_status')->where([
                    ['t_user_id', $user_id]
				])->orderBy("t_id", "desc")
                ->first();
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
    *       path="/transaction-topup-byid/{t_id}",
    *       tags={"Transaction"},
    *       operationId="lastTopUpByID",
    *       summary="Transaction - Get Top Up By ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID",
	*     example="1",
	*     in="path",
	*     name="t_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Transaction Berdasarkan ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Transaction",
    *               "data": {
    *                   {
    *						"t_id": "1",
    *						"t_transaction_id": "TRANS123",
    *						"t_code": "101",
    *						"t_user_id": "11",
    *						"t_p_id": null,
    *						"t_type": "inflow",
    *						"t_amount": 20000,
    *						"t_status": "unpaid",
    *						"t_user_proof": "user.jpg",
    *						"t_admin_proof": "admin.jpg",
    *						"t_created_date": "2024-03-12",
    *						"t_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function lastTopUpByID($t_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;

            $status = 1; // sudah acc admin
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Transaction';
				$data = tbl_transaction::select('t_id', 't_created_date', 't_amount', 't_status', 't_user_proof')->where([
                    ['t_id', $t_id]
				])->first();
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
	*     	operationId="confirmTopup",
	*     	tags={"Transaction"},
	*     	summary="Transaction - Confirm Top up",
	*     	description="Post data Transaction",
	*     	path="/transaction/confirm-topup",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
    *						"t_id": "1",
    *						"t_status": "waiting confirmation",
    *						"t_user_proof": "user.jpg",
    *						"t_modified_date": "2024-03-12"
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
	public function confirmTopup(Request $request) {
        //define validation rules
        $validator = Validator::make($request->all(), [
            't_id' => 'required',
            't_user_proof' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            't_status' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $fileName = $request->t_user_proof->getClientOriginalName();

        //last id for naming img file
        $extension = $request->t_user_proof->getClientOriginalExtension();
        $fileName = "User-Transaction-Topup". $request->input("t_id") .".".$extension;

        $request->t_user_proof->move(public_path('user_proof'), $fileName);

        //update filename
        $data = array(
            "t_user_proof"=>$fileName,
            "t_status"=>$request->input("t_status"),
            "t_modified_date"=>$request->input("t_modified_date")
        );

        $result = tbl_transaction::where([
                ['t_id', '=', $request->input("t_id")]
            ])->update($data);
		
		//make response JSON
		return response()->json([
			'success' => true,
			'data'    => $result
		], 201);
    }

    
    /**
	* 	@OA\Post(
	*     	operationId="validateTopup",
	*     	tags={"Transaction"},
	*     	summary="Transaction - Validate Top up",
	*     	description="Post data Transaction",
	*     	path="/transaction/validate-topup",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
    *						"t_id": "1",
    *						"t_status": "paid",
    *						"t_admin_proof": "admin.jpg",
    *						"t_modified_date": "2024-03-12"
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
	public function validateTopup(Request $request) {
        //define validation rules
        $validator = Validator::make($request->all(), [
            't_id' => 'required',
            't_admin_proof' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            't_status' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $fileName = $request->t_admin_proof->getClientOriginalName();

        //last id for naming img file
        $extension = $request->t_admin_proof->getClientOriginalExtension();
        $fileName = "Admin-Transaction-Topup". $request->input("t_id") .".".$extension;

        $request->t_admin_proof->move(public_path('admin_proof'), $fileName);

        //update filename
        $data = array(
            "t_admin_proof"=>$fileName,
            "t_status"=>$request->input("t_status"),
            "t_modified_date"=>$request->input("t_modified_date")
        );

        $result = tbl_transaction::where([
                ['t_id', '=', $request->input("t_id")]
            ])->update($data);
		
		//make response JSON
		return response()->json([
			'success' => true,
			'data'    => $result
		], 201);
    }

    
    /**
    *    @OA\Get(
    *       path="/transaction-byuserid/{user_id}",
    *       tags={"Transaction"},
    *       operationId="getUserFinance",
    *       summary="Transaction - Get All By User ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan User ID",
	*     example="1",
	*     in="path",
	*     name="user_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Transaction Berdasarkan User ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Transaction",
    *               "data": {
    *                   {
    *						"t_id": "1",
    *						"t_transaction_id": "TRANS123",
    *						"t_code": "101",
    *						"t_user_id": "11",
    *						"t_p_id": null,
    *						"t_type": "inflow",
    *						"t_amount": 20000,
    *						"t_status": "unpaid",
    *						"t_user_proof": "user.jpg",
    *						"t_admin_proof": "admin.jpg",
    *						"t_created_date": "2024-03-12",
    *						"t_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function getUserFinance($user_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;

            $status = 1; // sudah acc admin
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Transaction';
				$data = tbl_transaction::select('*')
                ->join('tbl_trans_activities', 'tbl_transaction.t_code', '=', 'tbl_trans_activities.code')
                ->where([
                    ['t_user_id', $user_id],
                    ['t_status', 'paid']
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
	* 	@OA\Delete(
	*     	operationId="deleteTransaction",
	*     	tags={"Transaction"},
	*     	summary="Transaction - Delete",
	*     	description="Delete data Transaction",
	*     	path="/transaction/delete",
	*     	security={{"bearerAuth":{}}},
	*    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
	*				"t_id": "1",
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
	public function deleteTransaction(Request $request) {
		//define validation rules
        $validator = Validator::make($request->all(), [
			  "t_id"     => 'required'
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
			
			$id = $request->input("t_id");
			$result = tbl_transaction::where([
					['t_id', '=', $id]
				])->delete();
		}
		
		//make response JSON
		return response()->json([
			'success' => $success,
			'message' => $message,
			'data'
		], 200);
    }
	

    /**
    *    @OA\Get(
    *       path="/transaction-topUp",
    *       tags={"Transaction"},
    *       operationId="listTopUp",
    *       summary="Transaction - Get All Top Up",
    *       description="Mengambil Data Transaction Top Up",
	*		security={{ "bearerAuth": {} }},
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Transaction Top Up",
    *               "data": {
    *                   {
    *						"t_id": "1",
    *						"t_transaction_id": "TRANS123",
    *						"t_code": "101",
    *						"t_user_id": "11",
    *						"t_p_id": null,
    *						"t_type": "inflow",
    *						"t_amount": 20000,
    *						"t_status": "unpaid",
    *						"t_user_proof": "user.jpg",
    *						"t_admin_proof": "admin.jpg",
    *						"t_created_date": "2024-03-12",
    *						"t_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listTopUp() {
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Berhasil mengambil Data Transaction Top Up';
			$data = tbl_transaction::select("*")
                                ->join('tbl_user', 't_user_id', '=', 'user_id')
                                ->orderBy("t_created_date", "desc")
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
    *       path="/transaction-course",
    *       tags={"Transaction"},
    *       operationId="listCourse",
    *       summary="Transaction - Get All Course",
    *       description="Mengambil Data Transaction Course",
	*		security={{ "bearerAuth": {} }},
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Transaction Course",
    *               "data": {
    *                   {
    *						"t_id": "1",
    *						"t_transaction_id": "TRANS123",
    *						"t_code": "101",
    *						"t_user_id": "11",
    *						"t_p_id": null,
    *						"t_type": "inflow",
    *						"t_amount": 20000,
    *						"t_status": "unpaid",
    *						"t_user_proof": "user.jpg",
    *						"t_admin_proof": "admin.jpg",
    *						"t_created_date": "2024-03-12",
    *						"t_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listCourse() {
		$token = request()->bearerToken();
		$success = false;
		$message = "Authorization Failed";
		$data = null;
		
		if ($this->checkToken($token)) {
			$success = true;
			$message = 'Berhasil mengambil Data Transaction Top Up';
			$data = tbl_transaction::select("*")
                                ->join('tbl_user', 't_user_id', '=', 'user_id')
                                ->join('tbl_product', 't_p_id', '=', 'p_id')
                                ->orderBy("t_created_date", "desc")
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
    *       path="/transaction-balance-byuserid/{user_id}",
    *       tags={"Transaction"},
    *       operationId="getBalanceByUserID",
    *       summary="Transaction - Get Balance By User ID",
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
    *       description="Mengambil Data Transaction Balance Berdasarkan User ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Balance Transaction",
    *               "data": {
    *                   {
    *						"t_id": "1",
    *						"t_transaction_id": "TRANS123",
    *						"t_code": "101",
    *						"t_user_id": "11",
    *						"t_p_id": null,
    *						"t_type": "inflow",
    *						"t_amount": 20000,
    *						"t_status": "unpaid",
    *						"t_user_proof": "user.jpg",
    *						"t_admin_proof": "admin.jpg",
    *						"t_created_date": "2024-03-12",
    *						"t_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function getBalanceByUserID($user_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;

            $balance = 0;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Transaction';
				$data = tbl_transaction::select('t_id', 't_code', 't_amount', 't_status','t_type')->where([
                    ['t_user_id', $user_id],
                    ['t_status', '=', 'paid']
				])->get();

                foreach ($data as $tr) {
                    if($tr['t_type']=='inflow'){
                        $balance += $tr['t_amount'];
                    } else {
                        $balance -= $tr['t_amount'];
                    }
                }
			}
			
			//make response JSON
			return response()->json([
				'success' => $success,
				'message' => $message,
				'data'    => $balance 
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
    *       path="/transaction-course-byuserid/{user_id}",
    *       tags={"Transaction"},
    *       operationId="listCourseByUserID",
    *       summary="Transaction - Get Course By User ID",
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
    *       description="Mengambil Data Transaction Berdasarkan User ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Transaction",
    *               "data": {
    *                   {
    *						"t_id": "1",
    *						"t_transaction_id": "TRANS123",
    *						"t_code": "101",
    *						"t_user_id": "11",
    *						"t_p_id": null,
    *						"t_type": "inflow",
    *						"t_amount": 20000,
    *						"t_status": "unpaid",
    *						"t_user_proof": "user.jpg",
    *						"t_admin_proof": "admin.jpg",
    *						"t_created_date": "2024-03-12",
    *						"t_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listCourseByUserID($user_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;

            $status = 1; // sudah acc admin
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Transaction';
				$data = tbl_transaction::select('*')
                ->join('tbl_product', 't_p_id', '=', 'p_id')
                ->where([
                    ['t_user_id', $user_id]
				])->orderBy("t_id", "desc")
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

}
