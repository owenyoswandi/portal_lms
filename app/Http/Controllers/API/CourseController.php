<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\tbl_product;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
    * @OA\Get(
    *     path="/course",
    *     tags={"Course"},
    *     operationId="listCourseAll",
    *     summary="Course - Get All",
    *     description="Get all course data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Course",
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
    *     path="/course",
    *     tags={"Course"},
    *     operationId="createCourse",
    *     summary="Course - Create",
    *     description="Create new course",
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
            'p_created_date' => 'required',
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
                    'p_created_date' => $request->p_created_date,
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
    *     path="/course/{id}",
    *     tags={"Course"},
    *     operationId="getCourse",
    *     summary="Course - Get By ID",
    *     description="Get course data by ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Course ID",
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
    *     path="/course/{id}",
    *     tags={"Course"},
    *     operationId="updateCourse",
    *     summary="Course - Update",
    *     description="Update course data with img upload",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Course ID",
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
    *     path="/course/{id}",
    *     tags={"Course"},
    *     operationId="deleteCourse",
    *     summary="Course - Delete",
    *     description="Delete course data and logo file",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Course ID",
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
                    $filePath = str_replace('storage/', '', $course->p_img);
                    Storage::delete($filePath);
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
