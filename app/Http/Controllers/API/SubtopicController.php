<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\tbl_subtopic;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SubtopicController extends Controller
{
    /**
    * @OA\Get(
    *     path="/subtopic-bytopicid/{id}",
    *     tags={"Subtopic"},
    *     operationId="getSubtopicByTopicId",
    *     summary="Subtopic - Get By Topic ID",
    *     description="Get Subtopic data by Topic ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Subtopic ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Topic",
    *             "data": {
    *                     "st_id": 1,
    *                     "st_t_id": 1,
    *                     "st_jenis": "Modul",
    *                     "st_name": "P1a Pengenalan Tools",
    *                     "st_file": "2024-01-14 10:00:00",
    *                     "st_start_date": "2024-01-14 10:00:00",
    *                     "st_due_date": "2024-01-14 10:00:00",
    *                     "st_duration": "15",
    *                     "st_attemp_allowed": "1",
    *                     "st_creadate": "2024-01-14 10:00:00",
    *                     "st_modidate": "2024-01-14 10:00:00"
    *             }
    *         })
    *     )
    * )
    */
    public function listSubtopicByTopicID($st_t_id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data Topic';
                $data = tbl_subtopic::where([
					['st_t_id', '=', $st_t_id]
				])->get();
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
    * @OA\Get(
    *     path="/subtopic",
    *     tags={"Subtopic"},
    *     operationId="listSubtopics",
    *     summary="Subtopic - Get All",
    *     description="Get all Subtopics data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Subtopic",
    *             "data": {
    *                 {
    *                     "st_id": 1,
    *                     "st_t_id": 1,
    *                     "st_jenis": "Modul",
    *                     "st_name": "P1a Pengenalan Tools",
    *                     "st_file": "2024-01-14 10:00:00",
    *                     "st_start_date": "2024-01-14 10:00:00",
    *                     "st_due_date": "2024-01-14 10:00:00",
    *                     "st_duration": "15",
    *                     "st_attemp_allowed": "1",
    *                     "st_creadate": "2024-01-14 10:00:00",
    *                     "st_modidate": "2024-01-14 10:00:00"
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
                $message = 'Berhasil mengambil Data Topic';
                $data = tbl_subtopic::all();
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
    *     path="/subtopic",
    *     tags={"Subtopic"},
    *     operationId="createSubtopic",
    *     summary="Subtopic - Create",
    *     description="Create new Subtopic with file upload",
    *     security={{ "bearerAuth": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 required={"st_t_id","st_jenis","st_name","st_file","st_due_date"},
    *                 @OA\Property(property="st_t_id", type="string", example="1"),
    *                 @OA\Property(property="st_jenis", type="string", example="Modul"),
    *                 @OA\Property(property="st_name", type="string", example="NLP"),
    *                 @OA\Property(property="st_file", type="file", format="binary", description="Subtopic file"),
    *                 @OA\Property(property="st_start_date", type="string", format="date-time"),
    *                 @OA\Property(property="st_due_date", type="string", format="date-time"),
    *                 @OA\Property(property="st_duration", type="string", example="15"),
    *                 @OA\Property(property="st_attemp_allowed", type="string", example="1"),
    *                 @OA\Property(property="st_creadate", type="string", format="date-time")
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
            'st_t_id' => 'required',
            'st_jenis' => 'required',
            'st_name' => 'required'
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
                $type = strtolower($request->st_jenis);
                $fileName = null;

                if($type=='modul' || $type=='task'){
                    $file = $request->file('st_file');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    
                    $file->move(public_path('uploads/'.$type), $fileName);
                    $fileName = 'uploads/' . $type. '/' . $fileName;
                } else {
                    $fileName = $request->st_file_else;
                }
                
                $data = tbl_subtopic::create([
                    'st_t_id' => $request->st_t_id,
                    'st_jenis' => $request->st_jenis,
                    'st_name' => $request->st_name,
                    'st_file' => $fileName,
                    'st_start_date' => $request->st_start_date,
                    'st_due_date' => $request->st_due_date,
                    'st_duration' => $request->st_duration,
                    'st_attemp_allowed' => $request->st_attemp_allowed,
                    'st_is_shuffle' => $request->st_is_shuffle,
                    'st_jumlah_shuffle' => $request->st_jumlah_shuffle,
                    'st_creadate' => $request->st_creadate
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
    *     path="/subtopic/{id}",
    *     tags={"Subtopic"},
    *     operationId="Subtopic",
    *     summary="Subtopic - Get By ID",
    *     description="Get Subtopic data by ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Subtopic ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Subtopic",
    *             "data": {
    *                     "st_id": 1,
    *                     "st_t_id": 1,
    *                     "st_jenis": "Modul",
    *                     "st_name": "P1a Pengenalan Tools",
    *                     "st_file": "2024-01-14 10:00:00",
    *                     "st_start_date": "2024-01-14 10:00:00",
    *                     "st_due_date": "2024-01-14 10:00:00",
    *                     "st_duration": "15",
    *                     "st_attemp_allowed": "1",
    *                     "st_creadate": "2024-01-14 10:00:00",
    *                     "st_modidate": "2024-01-14 10:00:00"
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
                $message = 'Berhasil mengambil Data Subtopic';
                $data = tbl_subtopic::findOrFail($id);
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
    *     path="/subtopic/{id}",
    *     tags={"Subtopic"},
    *     operationId="updateSubtopic",
    *     summary="Subtopic - Update",
    *     description="Update Subtopic data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Subtopic ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(property="_method", type="string", example="PUT", description="Need to be PUT"),
    *                 @OA\Property(property="st_id", type="string", example="1"),
    *                 @OA\Property(property="st_t_id", type="string", example="1"),
    *                 @OA\Property(property="st_jenis", type="string", example="Modul"),
    *                 @OA\Property(property="st_name", type="string", example="NLP"),
    *                 @OA\Property(property="st_file", type="file", format="binary", description="Subtopic file"),
    *                 @OA\Property(property="st_start_date", type="string", format="date-time"),
    *                 @OA\Property(property="st_due_date", type="string", format="date-time"),
    *                 @OA\Property(property="st_duration", type="string", example="15"),
    *                 @OA\Property(property="st_attemp_allowed", type="string", example="1"),
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
                $subtopic = tbl_subtopic::findOrFail($id);
                
                $updateData = $request->except('st_file');
                $fileName = null;
                
                if ($request->hasFile('st_file')) {
                    $type = strtolower($request->st_jenis);
                    if ($type=='modul' || $type=='task') {
                        unlink(public_path($subtopic->st_file));

                        // Store new file
                        $file = $request->file('st_file');
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->storeAs(''.$type, $fileName);

                        $fileName = ''. $type . '/' . $fileName;
                    } else {
                        $fileName = $subtopic->st_file_else;
                    }
                    
                    $updateData['st_file'] = $fileName;
                }
                
                $subtopic->update($updateData);
                
                $success = true;
                $message = 'Data berhasil diubah';
                $data = $subtopic;
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
    *     path="/subtopic/{id}",
    *     tags={"Subtopic"},
    *     operationId="deleteSubtopic",
    *     summary="Subtopic - Delete",
    *     description="Delete Subtopic data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Subtopic ID",
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
                $subtopic = tbl_subtopic::findOrFail($id);

                // Delete file if exists
                if ($subtopic->st_jenis=='Modul' || $subtopic->st_jenis=='Task') {
                    unlink(public_path($subtopic->st_file));
                }
                
                $subtopic->delete();
                
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
}