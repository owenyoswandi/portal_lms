<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\tbl_group;
use App\Models\tbl_group_access;
use App\Models\tbl_group_member;
use App\Models\tbl_product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    /**
    * @OA\Get(
    *     path="/group",
    *     tags={"Group"},
    *     operationId="listGroups",
    *     summary="Group - Get All",
    *     description="Get all groups data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Group",
    *             "data": {
    *                 {
    *                     "group_id": 1,
    *                     "group_name": "Hospital Group A",
    *                     "group_logo": "logo.png",
    *                     "group_email": "group@example.com",
    *                     "group_alamat": "Jakarta",
    *                     "group_phone": "021-1234567",
    *                     "group_creaby": "admin",
    *                     "group_creadate": "2024-01-14 10:00:00"
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
                $message = 'Berhasil mengambil Data Group';
                $data = tbl_group::withCount(['accesses', 'members'])->get();
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
    *     path="/group",
    *     tags={"Group"},
    *     operationId="createGroup",
    *     summary="Group - Create",
    *     description="Create new group with logo upload",
    *     security={{ "bearerAuth": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 required={"group_name","group_logo","group_email","group_alamat","group_phone","group_creaby","group_creadate"},
    *                 @OA\Property(property="group_name", type="string", example="Hospital Group A"),
    *                 @OA\Property(property="group_logo", type="file", format="binary", description="Logo image file"),
    *                 @OA\Property(property="group_email", type="string", format="email", example="group@example.com"),
    *                 @OA\Property(property="group_alamat", type="string", example="Jakarta"),
    *                 @OA\Property(property="group_phone", type="string", example="021-1234567"),
    *                 @OA\Property(property="group_creaby", type="string", example="admin"),
    *                 @OA\Property(property="group_creadate", type="string", format="date-time", example="2024-01-14 10:00:00")
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
            'group_name' => 'required',
            'group_logo' => 'required|file|mimes:jpeg,png,jpg|max:2048', // max 2MB
            'group_email' => 'required|email',
            'group_alamat' => 'required',
            'group_phone' => 'required',
            'group_creaby' => 'required',
            'group_creadate' => 'required|date',
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
                $file = $request->file('group_logo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                
                $file->move(public_path('uploads/group_logos'), $fileName);
                
                $data = tbl_group::create([
                    'group_name' => $request->group_name,
                    'group_logo' => 'uploads/group_logos/' . $fileName,
                    'group_email' => $request->group_email,
                    'group_alamat' => $request->group_alamat,
                    'group_phone' => $request->group_phone,
                    'group_creaby' => $request->group_creaby,
                    'group_creadate' => $request->group_creadate,
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
    *     path="/group/{id}",
    *     tags={"Group"},
    *     operationId="getGroup",
    *     summary="Group - Get By ID",
    *     description="Get group data by ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Group ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Group",
    *             "data": {
    *                 "group_id": 1,
    *                 "group_name": "Hospital Group A",
    *                 "group_logo": "logo.png",
    *                 "group_email": "group@example.com",
    *                 "group_alamat": "Jakarta",
    *                 "group_phone": "021-1234567",
    *                 "group_creaby": "admin",
    *                 "group_creadate": "2024-01-14 10:00:00"
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
                $message = 'Berhasil mengambil Data Group';
                $data = tbl_group::findOrFail($id);
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
    *     path="/group/{id}",
    *     tags={"Group"},
    *     operationId="updateGroup",
    *     summary="Group - Update",
    *     description="Update group data with logo upload",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Group ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(property="_method", type="string", example="PUT", description="Need to be PUT"),
    *                 @OA\Property(property="group_name", type="string"),
    *                 @OA\Property(property="group_logo", type="file", format="binary"),
    *                 @OA\Property(property="group_email", type="string", format="email"),
    *                 @OA\Property(property="group_alamat", type="string"),
    *                 @OA\Property(property="group_phone", type="string"),
    *                 @OA\Property(property="group_modiby", type="string"),
    *                 @OA\Property(property="group_modidate", type="string", format="date-time")
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
                $group = tbl_group::findOrFail($id);
                
                $updateData = $request->except('group_logo');
                
                if ($request->hasFile('group_logo')) {
                    if ($group->group_logo) {
                        $oldPath = str_replace('storage/', '', $group->group_logo);
                        Storage::delete($oldPath);
                    }
                    
                    // Store new file
                    $file = $request->file('group_logo');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('group_logos', $fileName);
                    
                    $updateData['group_logo'] = 'storage/group_logos/' . $fileName;
                }
                
                $group->update($updateData);
                
                $success = true;
                $message = 'Data berhasil diubah';
                $data = $group;
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
    *     path="/group/{id}",
    *     tags={"Group"},
    *     operationId="deleteGroup",
    *     summary="Group - Delete",
    *     description="Delete group data and logo file",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Group ID",
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
                $group = tbl_group::findOrFail($id);
                
                // Delete logo file if exists
                if ($group->group_logo) {
                    $filePath = str_replace('storage/', '', $group->group_logo);
                    Storage::delete($filePath);
                }
                
                $group->delete();
                
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

    

    /**
    *    @OA\Get(
    *       path="/group_access-byid/{group_id}",
    *       tags={"GroupAccess"},
    *       operationId="listGroupAccessById",
    *       summary="GroupAccess - Get By Id",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID",
	*     example="1",
	*     in="path",
	*     name="group_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data GroupAccess Berdasarkan ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data GroupAccess",
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
    public function listGroupAccessById($group_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data GroupAccess';
                $data = tbl_group_access::select('*')
                    ->join('tbl_product', 'tbl_group_access.product_id', '=', 'tbl_product.p_id')
                    ->where('tbl_group_access.group_id', '=',  $group_id)
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
     * @OA\Get(
     *   path="/group_access_courses-byid-byid/{group_id}",
     *   tags={"GroupAccess"},
     *   operationId="listGroupAccessCoursesById",
     *   summary="GroupAccess - Get All Right Join Course",
     *   security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan ID",
     *     example="1",
     *     in="path",
     *     name="group_id",
     *     required=true,
     *   ),
     *   description="Mengambil Data GroupAccess Berdasarkan ID",
     *   @OA\Response(
     *     response="200",
     *     description="Ok",
     *     @OA\JsonContent(
     *       example={
     *         "success": true,
     *         "message": "Berhasil mengambil Data GroupAccess",
     *         "data": {
     *           {
    *					"p_id": "1",
    *					"p_jenis": "Course",
    *					"p_judul": "NLP",
    *					"p_deskripsi": "Deskripsi",
    *					"p_img": "course/course.jpg",
    *					"p_id_lms": "4",
    *					"p_url_lms": "https:/",
    *					"p_harga": 10000,
    *					"p_status": 1,
    *					"p_created_date": "2024-03-12",
    *					"p_modified_date": null
     *           }
     *         }
     *       }
     *     ),
     *   ),
     * )
     */

    public function listGroupAccessCoursesById($group_id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            // Mengecek token
            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data GroupAccess';

                $data = tbl_product::select('tbl_product.*')
                    ->leftJoin('tbl_group_access', function ($join) use ($group_id) {
                        $join->on('tbl_product.p_id', '=', 'tbl_group_access.product_id')
                            ->where('tbl_group_access.group_id', '=', $group_id);
                    })
                    ->where('tbl_product.p_status', '=',  1)
                    ->whereNull('tbl_group_access.product_id')  // Menampilkan pertanyaan yang belum ada di group access
                    ->get();
            }

            // Mengembalikan respons JSON
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
    * @OA\Post(
    *     path="/group_access/create",
    *     tags={"GroupAccess"},
    *     operationId="insertGroupAccess",
    *     summary="GroupAccess - Create",
    *     description="Create new GroupAccess",
    *     security={{ "bearerAuth": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 required={"group_id","product_id"},
    *                 @OA\Property(property="group_id", type="string", example="1"),
    *                 @OA\Property(property="product_id", type="string", example="1")
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
    public function insertGroupAccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required'
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
                // Get the product IDs from the request
                $productIds = json_decode($request->input('productIds'));
                $groupId = $request->input('group_id');

                // Ensure that submission IDs are provided
                if (empty($productIds)) {
                    $message = 'No quetions selected.';
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                        'data' => $data
                    ], 400);
                }
                foreach ($productIds as $id) {
                    $data = tbl_group_access::create([
                        'group_id' => $groupId,
                        'product_id' => $id
                    ]);
                }

                $success = true;
                $message = 'Data berhasil disimpan GroupAccess';
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
    * @OA\Delete(
    *     path="/group_access/delete",
    *     tags={"GroupAccess"},
    *     operationId="deleteGroupAccess",
    *     summary="GroupAccess - Delete",
    *     description="Delete GroupAccess data",
    *     security={{ "bearerAuth": {} }},
    *    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
    *				"group_id": "1",
    *				"product_id": "1",
    *             },
    *         ),
    *     	),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Data berhasil dihapus",
    *             "data": {
    *  				    "group_id": "1",
    *  				    "product_id": "1",
    *				},
    *         })
    *     )
    * )
    */
    public function deleteGroupAccess(Request $request)
    {
        $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;

        if ($this->checkToken($token)) {
            try {
                $group_access = tbl_group_access::where('group_id', $request->input("group_id"))
                    ->where('product_id', $request->input("product_id"))
                    ->delete();
                
                $success = true;
                $message = 'Data berhasil dihapus';
                $data = true;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting topic: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    /**
    *    @OA\Get(
    *       path="/group_member-byid/{group_id}",
    *       tags={"GroupMember"},
    *       operationId="listGroupMemberById",
    *       summary="GroupMember - Get By Id",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID",
	*     example="1",
	*     in="path",
	*     name="group_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data GroupMember Berdasarkan ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data GroupMember",
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
    public function listGroupMemberById($group_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data GroupMember';
                $data = tbl_group_member::select('*')
                    ->join('tbl_user', 'tbl_group_member.user_id', '=', 'tbl_user.user_id')
                    ->where('tbl_group_member.group_id', '=',  $group_id)
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