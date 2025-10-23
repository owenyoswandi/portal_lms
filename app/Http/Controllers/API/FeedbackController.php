<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_feedback;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
/**
 * @OA\Get(
 *     path="/feedback-course/{course_id}/{user_id}",
 *     tags={"feedback"},
 *     operationId="listfeedbacks",
 *     summary="Feedback - Get All by Course ID and User ID",
 *     description="Get all feedbacks data for a specific course and user",
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         name="course_id",
 *         in="path",
 *         required=true,
 *         description="Course ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(example={
 *             "success": true,
 *             "message": "Berhasil mengambil Data Feedback berdasarkan Course ID dan User ID",
 *             "data": {
 *                 {
 *                     "feedback_id": 1,
 *                     "course_id": 1,
 *                     "user_id": 1,
 *                     "feedback": "Great course content!",
 *                     "rating": 5,
 *                     "created_at": "2024-01-14 10:00:00",
 *                     "modified_at": "2024-01-14 10:00:00",
 *                     "user_name": "John Doe"
 *                 }
 *             }
 *         })
 *     )
 * )
 */
    public function index($subtopic_id, $user_id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data Feedback berdasarkan Course ID';
                $data = tbl_feedback::where([['subtopic_id', $subtopic_id], ['tbl_feedback.user_id', $user_id]])
                ->join('tbl_user', 'tbl_feedback.user_id', '=', 'tbl_user.user_id')
                ->select('tbl_feedback.*', 'tbl_user.nama')
                ->get();    
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

    public function index2($subtopic_id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data Feedback berdasarkan Course ID';
                $data = tbl_feedback::where([['subtopic_id', $subtopic_id]])
                ->join('tbl_user', 'tbl_feedback.user_id', '=', 'tbl_user.user_id')
                ->select('tbl_feedback.*', 'tbl_user.nama')
                ->get();    
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
    *     path="/feedback",
    *     tags={"feedback"},
    *     operationId="createfeedback",
    *     summary="Feedback - Create",
    *     description="Create new feedback",
    *     security={{ "bearerAuth": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"course_id","user_id","feedback","rating"},
    *             @OA\Property(property="course_id", type="integer", example=1),
    *             @OA\Property(property="user_id", type="integer", example=1),
    *             @OA\Property(property="feedback", type="string", example="Great course content!"),
    *             @OA\Property(property="rating", type="integer", example=5)
    *         )
    *     ),
    *     @OA\Response(
    *         response="201",
    *         description="Created",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Data berhasil disimpan",
    *             "data": {
    *                 "feedback_id": 1,
    *                 "course_id": 1,
    *                 "user_id": 1,
    *                 "feedback": "Great course content!",
    *                 "rating": 5,
    *                 "created_at": "2024-01-14 10:00:00",
    *                 "modified_at": "2024-01-14 10:00:00"
    *             }
    *         })
    *     )
    * )
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'subtopic_id'=> 'required',
            'user_id' => 'required',
            'feedback' => 'required',
            'rating' => 'required'
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
                $data = tbl_feedback::create([
                    'subtopic_id' => $request->subtopic_id,
                    'course_id' => $request->course_id,
                    'user_id' => $request->user_id,
                    'feedback' => $request->feedback,
                    'rating' => $request->rating,
                    'created_at' => date('Y-m-d H:i:s'),
                    'modified_at' => date('Y-m-d H:i:s'),
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
    *     path="/feedback/{id}",
    *     tags={"feedback"},
    *     operationId="getfeedback",
    *     summary="Feedback - Get By ID",
    *     description="Get feedback data by ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Feedback ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Feedback berdasarkan ID",
    *             "data": {
    *                 "feedback_id": 1,
    *                 "course_id": 1,
    *                 "user_id": 1,
    *                 "feedback": "Great course content!",
    *                 "rating": 5,
    *                 "created_at": "2024-01-14 10:00:00",
    *                 "modified_at": "2024-01-14 10:00:00"
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
                $message = 'Berhasil mengambil Data Feedback berdasarkan ID';
                $data = tbl_feedback::findOrFail($id);
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
    * @OA\Put(
    *     path="/feedback/{id}",
    *     tags={"feedback"},
    *     operationId="updatefeedback",
    *     summary="Feedback - Update",
    *     description="Update feedback data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Feedback ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             @OA\Property(property="course_id", type="integer"),
    *             @OA\Property(property="user_id", type="integer"),
    *             @OA\Property(property="feedback", type="string"),
    *             @OA\Property(property="rating", type="integer")
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Data berhasil diubah",
    *             "data": {
    *                 "feedback_id": 1,
    *                 "course_id": 1,
    *                 "user_id": 1,
    *                 "feedback": "Updated feedback content",
    *                 "rating": 4,
    *                 "created_at": "2024-01-14 10:00:00",
    *                 "modified_at": "2024-01-14 10:00:00"
    *             }
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
                $feedback = tbl_feedback::findOrFail($id);
                
                $updateData = $request->all();
                $updateData['modified_at'] = date('Y-m-d H:i:s');
                $feedback->update($updateData);
                
                $success = true;
                $message = 'Data berhasil diubah';
                $data = $feedback;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating feedback: ' . $e->getMessage()
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
    *     path="/feedback/{id}",
    *     tags={"feedback"},
    *     operationId="deletefeedback",
    *     summary="Feedback - Delete",
    *     description="Delete feedback data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Feedback ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Data berhasil dihapus",
    *             "data": true
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
                $feedback = tbl_feedback::findOrFail($id);
                $feedback->delete();
                
                $success = true;
                $message = 'Data berhasil dihapus';
                $data = true;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting feedback: ' . $e->getMessage()
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
