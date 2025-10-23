<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\tbl_topic;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TopicController extends Controller
{
    /**
    * @OA\Get(
    *     path="/topic-byproductid/{id}",
    *     tags={"Topic"},
    *     operationId="getTopicByProductId",
    *     summary="Topic - Get By Product ID",
    *     description="Get topic data by Product ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Topic ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Topic",
    *             "data": {
    *                     "t_id": 1,
    *                     "t_p_id": 1,
    *                     "t_name": "P1 Instalasi",
    *                     "t_creadate": "2024-01-14 10:00:00",
    *                     "t_modidate": "2024-01-14 10:00:00"
    *             }
    *         })
    *     )
    * )
    */
    public function listTopicByProductID($t_p_id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data Topic';
                $data = tbl_topic::where([
					['t_p_id', '=', $t_p_id]
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
    *     path="/topic",
    *     tags={"Topic"},
    *     operationId="listTopics",
    *     summary="Topic - Get All",
    *     description="Get all topics data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Topic",
    *             "data": {
    *                 {
    *                     "t_id": 1,
    *                     "t_p_id": 1,
    *                     "t_name": "P1 Instalasi",
    *                     "t_creadate": "2024-01-14 10:00:00",
    *                     "t_modidate": "2024-01-14 10:00:00"
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
                $data = tbl_topic::all();
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
    *     path="/topic",
    *     tags={"Topic"},
    *     operationId="createTopic",
    *     summary="Topic - Create",
    *     description="Create new topic with logo upload",
    *     security={{ "bearerAuth": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 required={"t_p_id, t_name"},
    *                 @OA\Property(property="t_p_id", type="string", example="1"),
    *                 @OA\Property(property="t_name", type="string", example="P1 Instalasi")
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
            't_p_id' => 'required',
            't_name' => 'required',
            't_creadate' => 'required'
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
                $data = tbl_topic::create([
                    't_p_id' => $request->t_p_id,
                    't_name' => $request->t_name,
                    't_creadate' => $request->t_creadate
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
    *     path="/topic/{id}",
    *     tags={"Topic"},
    *     operationId="getTopic",
    *     summary="Topic - Get By ID",
    *     description="Get topic data by ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Topic ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Topic",
    *             "data": {
    *                     "t_id": 1,
    *                     "t_p_id": 1,
    *                     "t_name": "P1 Instalasi",
    *                     "t_creadate": "2024-01-14 10:00:00",
    *                     "t_modidate": "2024-01-14 10:00:00"
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
                $message = 'Berhasil mengambil Data Topic';
                $data = tbl_topic::findOrFail($id);
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
    *     path="/topic/{id}",
    *     tags={"Topic"},
    *     operationId="updateTopic",
    *     summary="Topic - Update",
    *     description="Update topic data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Topic ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(property="_method", type="string", example="PUT", description="Need to be PUT"),
    *                 @OA\Property(property="t_id", type="string", example="1"),
    *                 @OA\Property(property="t_name", type="string", example="P1 Instalasi")
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
                $topic = tbl_topic::findOrFail($id);

                $topic->update($request->all());
                
                $success = true;
                $message = 'Data berhasil diubah';
                $data = $topic;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating topic: ' . $e->getMessage()
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
    *     path="/topic/{id}",
    *     tags={"Topic"},
    *     operationId="deleteTopic",
    *     summary="Topic - Delete",
    *     description="Delete topic data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Topic ID",
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
                $topic = tbl_topic::findOrFail($id);
                
                $topic->delete();
                
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

    public function getTopicsByCourse($p_id)
    {
        $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;

        if ($this->checkToken($token)) {
            try {
                // Fetch topics for the given category ID and load their subtopics
                $topics = tbl_topic::with('subtopics')->where('t_p_id', $p_id)->get();
                
                $success = true;
                $message = 'Berhasil mengambil data';
                $data = true;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting topic: ' . $e->getMessage()
                ], 500);
            }
        }

        // Return the response as JSON
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $topics
        ], 200);
    }
}