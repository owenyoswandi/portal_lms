<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_product;
use App\Models\tbl_transaction;
use App\Models\tbl_group_member;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    
    /**
    *    @OA\Get(
    *       path="/product-byjenis/{p_jenis}",
    *       tags={"Product"},
    *       operationId="listProductByJenis",
    *       summary="Product - Get By Jenis",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="course",
	*       type="string",
	*     ),
	*     description="Masukan Jenis",
	*     example="course",
	*     in="path",
	*     name="p_jenis",
	*     required=true,
	*   ),
    *       description="Mengambil Data Product Berdasarkan Jenis",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Product",
    *               "data": {
    *                   {
    *						"p_id": "1",
    *						"p_jenis": "Course",
    *						"p_judul": "NLP",
    *						"p_deskripsi": "Deskripsi",
    *						"p_img": "course/course.jpg",
    *						"p_id_lms": "4",
    *						"p_url_lms": "https:/",
    *						"p_harga": 10000,
    *						"p_status": 0,
    *						"p_created_date": "2024-03-12",
    *						"p_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listProductByJenis($p_jenis) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			//if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Product';
				$data = tbl_product::where([
					['p_jenis', '=', $p_jenis]
				])->get();
			//}
			
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
    *       path="/product-byjenisstatus/{p_jenis}/{user_id}",
    *       tags={"Product"},
    *       operationId="listProductByJenisStatus",
    *       summary="Product - Get By Jenis",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="course",
	*       type="string",
	*     ),
	*     description="Masukan Jenis",
	*     example="course",
	*     in="path",
	*     name="p_jenis",
	*     required=true,
	*   ),
    *   @OA\Parameter(
	*     @OA\Schema(
	*       default="11",
	*       type="string",
	*     ),
	*     description="Masukan User id",
	*     example="11",
	*     in="path",
	*     name="user_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Product Berdasarkan Jenis",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Product",
    *               "data": {
    *                   {
    *						"p_id": "1",
    *						"p_jenis": "Course",
    *						"p_judul": "NLP",
    *						"p_deskripsi": "Deskripsi",
    *						"p_img": "course/course.jpg",
    *						"p_id_lms": "4",
    *						"p_url_lms": "https:/",
    *						"p_harga": 10000,
    *						"p_status": 1,
    *						"p_created_date": "2024-03-12",
    *						"p_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listProductByJenisStatus($p_jenis, $user_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			//if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Product';

                $data = tbl_product::select('tbl_product.*', 'tbl_transaction.t_status')
                    ->leftJoin('tbl_transaction', function ($join) use ($user_id) {
                        $join->on('tbl_product.p_id', '=', 'tbl_transaction.t_p_id')
                            ->where('tbl_transaction.t_user_id', '=', $user_id);
                    })
                    ->where('p_jenis', $p_jenis)
                    ->whereNull('tbl_transaction.t_status')
                    ->get();
			//}
			
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
    *       path="/product-byjenisstatusgroup/{p_jenis}/{user_id}",
    *       tags={"Product"},
    *       operationId="listProductByJenisStatusGroup",
    *       summary="Product - Get By Jenis StatusGroup",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="course",
	*       type="string",
	*     ),
	*     description="Masukan Jenis",
	*     example="course",
	*     in="path",
	*     name="p_jenis",
	*     required=true,
	*   ),
    *   @OA\Parameter(
	*     @OA\Schema(
	*       default="11",
	*       type="string",
	*     ),
	*     description="Masukan User id",
	*     example="11",
	*     in="path",
	*     name="user_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Product Berdasarkan Jenis",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Product",
    *               "data": {
    *                   {
    *						"p_id": "1",
    *						"p_jenis": "Course",
    *						"p_judul": "NLP",
    *						"p_deskripsi": "Deskripsi",
    *						"p_img": "course/course.jpg",
    *						"p_id_lms": "4",
    *						"p_url_lms": "https:/",
    *						"p_harga": 10000,
    *						"p_status": 1,
    *						"p_created_date": "2024-03-12",
    *						"p_modified_date": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listProductByJenisStatusGroup($p_jenis, $user_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			//if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Product';

                $group = tbl_group_member::where('user_id', $user_id)->first();

                if ($group) {
                    $data = tbl_product::select('tbl_product.*', 'tbl_transaction.t_status')
                        // Join transaksi untuk cek apakah user sudah punya course ini
                        ->leftJoin('tbl_transaction', function ($join) use ($user_id) {
                            $join->on('tbl_product.p_id', '=', 'tbl_transaction.t_p_id')
                                ->where('tbl_transaction.t_user_id', '=', $user_id);
                        })

                        // Join ke tbl_group_access untuk pastikan course ada dalam group tertentu
                        ->join('tbl_group_access', function ($join) use ($group) {
                            $join->on('tbl_group_access.product_id', '=', 'tbl_product.p_id')
                                ->where('tbl_group_access.group_id', '=', $group->group_id); // Menggunakan $group->group_id
                        })

                        // Filter jenis course
                        ->where('p_jenis', $p_jenis)

                        // Hanya course yang belum ada transaksi
                        ->whereNull('tbl_transaction.t_status')

                        ->get();
                } else {
                    // $data = tbl_product::select('tbl_product.*', 'tbl_transaction.t_status')
                    //     ->leftJoin('tbl_transaction', function ($join) use ($user_id) {
                    //         $join->on('tbl_product.p_id', '=', 'tbl_transaction.t_p_id')
                    //             ->where('tbl_transaction.t_user_id', '=', $user_id);
                    //     })
                    //     ->where('p_jenis', $p_jenis)
                    //     ->whereNull('tbl_transaction.t_status')
                    //     ->where('p_status', 1) // Menambahkan kondisi untuk p_status = 1
                    //     ->get();
                }
               

			//}
			
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
    * @OA\Get(
    *     path="/product",
    *     tags={"Product"},
    *     operationId="listProduct",
    *     summary="Product - Get All",
    *     description="Get all product data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Product Course",
    *             "data": {
    *                 {
    *						"p_id": "1",
    *						"p_jenis": "Course",
    *						"p_judul": "NLP",
    *						"p_deskripsi": "Deskripsi",
    *						"p_img": "course/course.jpg",
    *						"p_id_lms": "1",
    *						"p_url_lms": "https:/",
    *						"p_harga": 10000,
    *						"p_status": 0,
    *						"p_start_date": "2024-03-12",
    *						"p_end_date": "2024-03-12",
    *						"p_created_date": "2024-03-12",
    *						"p_modified_date": null
    *                 }
    *             }
    *         })
    *     )
    * )
    */
    public function index()
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data Course';
                $data = tbl_product::all();
            }

            return response()->json([
                'success' => $success,
                'message' => $message,
                'data'    => $data
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
    * @OA\Post(
    *     path="/product",
    *     tags={"Product"},
    *     operationId="createProduct",
    *     summary="Product - Create",
    *     description="Create new product",
    *     security={{ "bearerAuth": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 required={"p_jenis","p_judul","p_deskripsi","p_img","p_id_lms","p_url_lms","p_harga","p_status", "p_start_date", "p_end_date"},
    *                 @OA\Property(property="p_jenis", type="string", example="Course"),
    *                 @OA\Property(property="p_judul", type="string", example="NLP"),
    *                 @OA\Property(property="p_deskripsi", type="string", example="Deskripsi"),
    *                 @OA\Property(property="p_img", type="file", format="binary", description="Course image file"),
    *                 @OA\Property(property="p_id_lms", type="string", example="1"),
    *                 @OA\Property(property="p_url_lms", type="string", example="https:/"),
    *                 @OA\Property(property="p_harga", type="string", example="10000"),
    *                 @OA\Property(property="p_status", type="string", example="0"),
    *                 @OA\Property(property="p_start_date", type="string", format="date-time"),
    *                 @OA\Property(property="p_end_date", type="string", format="date-time")
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response="201",
    *         description="Created",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Data berhasil disimpan",
    *             "data": null
    *         })
    *     )
    * )
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'p_jenis' => 'required',
            'p_judul' => 'required',
            'p_deskripsi' => 'required',
            'p_img' => 'required|file|mimes:jpeg,png,jpg|max:2048', // max 2MB
            'p_id_lms' => 'required',
            'p_url_lms' => 'required',
            'p_harga' => 'required',
            'p_status' => 'required',
            'p_start_date' => 'required|date',
            'p_end_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;

        if ($this->checkToken($token)) {
            try {
                $file = $request->file('p_img');
                $fileName = time() . '_' . $file->getClientOriginalName();
                
                $file->move(public_path('uploads/course'), $fileName);
                
                $data = tbl_product::create([
                    'p_jenis' => $request->p_jenis,
                    'p_judul' => $request->p_judul,
                    'p_deskripsi' => $request->p_deskripsi,
                    'p_img' => 'uploads/course/' . $fileName,
                    'p_id_lms' => $request->p_id_lms,
                    'p_url_lms' => $request->p_url_lms,
                    'p_harga' => $request->p_harga,
                    'p_status' => $request->p_status,
                    'p_start_date' => $request->p_start_date,
                    'p_end_date' => $request->p_end_date
                ]);

                $success = true;
                $message = 'Data berhasil disimpan';
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error uploading file: ' . $e->getMessage()
                ], 500);
            }
        }
        
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ], 201);
    }

    /**
    * @OA\Get(
    *     path="/product/{id}",
    *     tags={"Product"},
    *     operationId="getProduct",
    *     summary="Product - Get By ID",
    *     description="Get product data by ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Product ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Group",
    *             "data": {
    *						"p_id": "1",
    *						"p_jenis": "Course",
    *						"p_judul": "NLP",
    *						"p_deskripsi": "Deskripsi",
    *						"p_img": "course/course.jpg",
    *						"p_id_lms": "1",
    *						"p_url_lms": "https:/",
    *						"p_harga": 10000,
    *						"p_status": 0,
    *						"p_start_date": "2024-03-12",
    *						"p_end_date": "2024-03-12",
    *						"p_created_date": "2024-03-12",
    *						"p_modified_date": null
    *             }
    *         })
    *     )
    * )
    */
    public function show($id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data Course';
                $data = tbl_product::findOrFail($id);
            }

            return response()->json([
                'success' => $success,
                'message' => $message,
                'data'    => $data
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
    * @OA\POST(
    *     path="/product/{id}",
    *     tags={"Product"},
    *     operationId="updateProduct",
    *     summary="Product - Update",
    *     description="Update product data with img upload",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Product ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(property="_method", type="string", example="PUT", description="Need to be PUT"),
    *                 @OA\Property(property="p_judul", type="string", example="NLP"),
    *                 @OA\Property(property="p_deskripsi", type="string", example="Deskripsi"),
    *                 @OA\Property(property="p_img", type="file", format="binary", description="Course image file"),
    *                 @OA\Property(property="p_harga", type="string", example="10000"),
    *                 @OA\Property(property="p_status", type="string", example="0"),
    *                 @OA\Property(property="p_start_date", type="string", format="date-time"),
    *                 @OA\Property(property="p_end_date", type="string", format="date-time"),
    *                 @OA\Property(property="p_modified_date", type="string", format="date-time")
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Data berhasil diubah",
    *             "data": null
    *         })
    *     )
    * )
    */
    public function update(Request $request, $id)
    {

        $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;

        if ($this->checkToken($token)) {
            try {
                $course = tbl_product::findOrFail($id);
                
                $updateData = $request->except('p_img');
                
                if ($request->hasFile('p_img')) {
                    if ($course->p_img) {
                        unlink(public_path($course->p_img));
                        // $oldPath = str_replace('storage/', '', $course->p_img);
                        // Storage::delete($oldPath);
                    }
                    
                    // Store new file
                    $file = $request->file('p_img');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/course'), $fileName);
                    
                    $updateData['p_img'] = 'uploads/course/' . $fileName;
                }
                
                $course->update($updateData);
                
                $success = true;
                $message = 'Data berhasil diubah';
                $data = $course;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating group: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ], 200);
    }

    /**
    * @OA\Delete(
    *     path="/product/{id}",
    *     tags={"Product"},
    *     operationId="deleteProduct",
    *     summary="Product - Delete",
    *     description="Delete Product data and logo file",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Product ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Data berhasil dihapus",
    *             "data": null
    *         })
    *     )
    * )
    */
    public function destroy($id)
    {
        $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;

        if ($this->checkToken($token)) {
            try {
                $course = tbl_product::findOrFail($id);
                
                // Delete logo file if exists
                if ($course->p_img) {
                    unlink(public_path($course->p_img));
                }
                
                $course->delete();
                
                $success = true;
                $message = 'Data berhasil dihapus';
                $data = true;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting group: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], 200);
    }

}
