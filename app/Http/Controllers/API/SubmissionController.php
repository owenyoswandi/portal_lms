<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_submission;
use App\Models\tbl_topic;
use App\Models\tbl_product;
use App\Models\tbl_transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;

class SubmissionController extends Controller
{
    /**
    *    @OA\Get(
    *       path="/submission-bytaskUser/{st_id}/{user_id}",
    *       tags={"Submission"},
    *       operationId="listSubmissionBySubtopicUserID",
    *       summary="Submission - Get By Subtopic and User ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID Subtopic",
	*     example="1",
	*     in="path",
	*     name="st_id",
	*     required=true,
	*   ),
    *   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan User id",
	*     example="11",
	*     in="path",
	*     name="user_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Submission Berdasarkan Subtopic dan User ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Submission",
    *               "data": {
    *                   {
    *						"sm_id": "1",
    *						"sm_st_id": "1",
    *						"sm_user_id": "1",
    *						"sm_file": "uploads/submission/",
    *						"sm_comment": "",
    *						"sm_status": "1",
    *						"sm_creadate": "2024-03-12",
    *						"sm_modidate": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listSubmissionBySubtopicUserID($st_id, $user_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Submission';

                $tbl_submission = tbl_submission::select('*')
                ->where([
					['sm_st_id', '=', $st_id],
                    ['sm_user_id', '=', $user_id]
				])->first();
			}
			
			//make response JSON
			return response()->json([
				'success' => $success,
				'message' => $message,
				'data'    => $tbl_submission  
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
    *       path="/submission-bytask/{st_id}",
    *       tags={"Submission"},
    *       operationId="listSubmissionBySubtopicID",
    *       summary="Submission - Get By Subtopic",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID Subtopic",
	*     example="1",
	*     in="path",
	*     name="st_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Submission Berdasarkan Subtopic",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Submission",
    *               "data": {
    *                   {
    *						"sm_id": "1",
    *						"sm_st_id": "1",
    *						"sm_user_id": "1",
    *						"sm_file": "uploads/submission/",
    *						"sm_comment": "",
    *						"sm_status": "1",
    *						"sm_creadate": "2024-03-12",
    *						"sm_modidate": null
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listSubmissionBySubtopicID($subtopicId) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Submission';

                $data = tbl_transaction::join('tbl_user', 'tbl_transaction.t_user_id', '=', 'tbl_user.user_id')
                    ->join('tbl_product', 'tbl_transaction.t_p_id', '=', 'tbl_product.p_id')
                    ->join('tbl_topic', 'tbl_product.p_id', '=', 'tbl_topic.t_p_id')
                    ->join('tbl_subtopic', 'tbl_topic.t_id', '=', 'tbl_subtopic.st_t_id')
                    ->leftJoin('tbl_submission as sm', function($join) {
                        $join->on('tbl_subtopic.st_id', '=', 'sm.sm_st_id')
                             ->on('tbl_user.user_id', '=', 'sm.sm_user_id');
                    })
                    ->where('tbl_subtopic.st_id', '=', $subtopicId)
                    ->orderBy('sm.sm_creadate', 'desc')  // Order by the submission date (latest first)
                    ->groupBy('tbl_user.user_id') 
                    ->select(
                        'tbl_user.user_id', 
                        'tbl_user.nama', 
                        'sm.sm_id', 
                        'sm.sm_creadate', 
                        'sm.sm_status', 
                        'sm.sm_comment',
                        'sm.sm_file',
                        'sm.sm_grade', 
                        'sm.sm_feedback_comment'
                    )
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
    *     path="/submission",
    *     tags={"Submission"},
    *     operationId="listAllSubmission",
    *     summary="Submission - Get All",
    *     description="Get all submission data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Submission",
    *             "data": {
    *                 {
    *						"sm_id": "1",
    *						"sm_st_id": "1",
    *						"sm_user_id": "1",
    *						"sm_file": "uploads/submission/",
    *						"sm_comment": "",
    *						"sm_status": "1",
    *						"sm_creadate": "2024-03-12",
    *						"sm_modidate": null
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
                $message = 'Berhasil mengambil Data Submission';
                $data = tbl_submission::all();
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
    *     path="/submission",
    *     tags={"Submission"},
    *     operationId="createSubmission",
    *     summary="Submission - Create",
    *     description="Create new submission",
    *     security={{ "bearerAuth": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 required={"sm_st_id","sm_user_id","sm_file","sm_comment","sm_status","sm_creadate"},
    *                 @OA\Property(property="sm_st_id", type="string", example="1"),
    *                 @OA\Property(property="sm_user_id", type="string", example="1"),
    *                 @OA\Property(property="sm_file", type="file", format="binary", description="Submission file"),
    *                 @OA\Property(property="sm_comment", type="string", example="1"),
    *                 @OA\Property(property="sm_status", type="string", example=""),
    *                 @OA\Property(property="sm_creadate", type="string", format="date-time")
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
            'sm_st_id' => 'required',
            'sm_user_id' => 'required',
            'files' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Array untuk menyimpan path file
        // $filePaths = [];
        $file = $request->file('files');

        $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;

        if ($this->checkToken($token)) {
            try {

                $cek = tbl_submission::where('sm_st_id', $request->sm_st_id)
                        ->where('sm_user_id', $request->sm_user_id)
                        ->first();

                if($cek){
                    $updateData = $request->except('files');

                    unlink(public_path($cek->sm_file));
                    if($file){
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        
                        $file->move(public_path('uploads/submission'), $fileName);
                        $fileName = 'uploads/submission/' . $fileName;
                    }
                    $updateData['sm_file'] = $fileName;
                    $cek->update($updateData);
                } else {
                    if($file){
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        
                        $file->move(public_path('uploads/submission'), $fileName);
                        $fileName = 'uploads/submission/' . $fileName;
                    }
    
                    // foreach ($request->file('files') as $file) {
                    //     $fileName = time() . '_' . $file->getClientOriginalName();
                        
                    //     $file->move(public_path('uploads/submission'), $fileName);
                    //     $fileName = 'uploads/submission/' . $fileName;
            
                    //     // Menambahkan path file ke array
                    //     $filePaths[] = $fileName;
                    // }
    
                    // $data = tbl_submission::create([
                    //     'sm_st_id' => $request->sm_st_id,
                    //     'sm_user_id' => $request->sm_user_id,
                    //     'sm_file' => json_encode($filePaths),
                    //     'sm_status' => $request->sm_status,
                    //     'sm_creadate' => $request->sm_creadate
                    // ]);                
    
                    $data = tbl_submission::create([
                        'sm_st_id' => $request->sm_st_id,
                        'sm_user_id' => $request->sm_user_id,
                        'sm_file' => $fileName,
                        'sm_status' => $request->sm_status,
                        'sm_creadate' => $request->sm_creadate
                    ]);
                }

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
    *     path="/submission/{id}",
    *     tags={"Submission"},
    *     operationId="Submission",
    *     summary="Submission - Get By ID",
    *     description="Get Submission data by ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Submission ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data Submission",
    *             "data": {
    *						"sm_id": "1",
    *						"sm_st_id": "1",
    *						"sm_user_id": "1",
    *						"sm_file": "uploads/submission/",
    *						"sm_comment": "",
    *						"sm_status": "1",
    *						"sm_creadate": "2024-03-12",
    *						"sm_modidate": null
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
                $message = 'Berhasil mengambil Data Submission';
                $data = tbl_submission::findOrFail($id);
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
    *     path="/submission/{id}",
    *     tags={"Submission"},
    *     operationId="updateSubmission",
    *     summary="Submission - Update",
    *     description="Update Submission data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Submission ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(property="_method", type="string", example="PUT", description="Need to be PUT"),
    *                 @OA\Property(property="sm_id", type="string", example="1"),
    *                 @OA\Property(property="sm_grade", type="string", example="8")
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
                $submission = tbl_submission::findOrFail($id);

                $submission->update($request->all());
                
                $success = true;
                $message = 'Data berhasil diubah';
                $data = $submission;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating submission: ' . $e->getMessage()
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
    *     path="/submission/{id}",
    *     tags={"Submission"},
    *     operationId="deleteSubmission",
    *     summary="Submission - Delete",
    *     description="Delete Submission data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="Submission ID",
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
                $submission = tbl_submission::findOrFail($id);

                // Delete file if exists
                if ($submission->sm_file) {
                    unlink(public_path($submission->sm_file));
                }
                
                $submission->delete();
                
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


    public function downloadSubmission(Request $request) 
    {
        $token = $request->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;

        // Validate the token
        if ($this->checkToken($token)) {
            try {
                // Get the submission IDs from the request
                $submissionIds = json_decode($request->input('submissionIds'));

                // Ensure that submission IDs are provided
                if (empty($submissionIds)) {
                    $message = 'No submission selected for download.';
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                        'data' => $data
                    ], 400);
                }

                // Get the file paths based on submission IDs
                $files = [];
                foreach ($submissionIds as $id) {
                    $submission = tbl_submission::findOrFail($id);
                    $filePath = public_path($submission->sm_file); 
                    if (File::exists($filePath)) {
                        $files[] = $filePath;
                    } else {
                        $message = "File not found for submission ID: $id";
                        return response()->json([
                            'success' => false,
                            'message' => $message,
                            'data' => $data
                        ], 404);
                    }
                }

                // If only one file, return it directly
                if (count($files) === 1) {
                    $filePath = $files[0];
                    $fileName = basename($filePath);
                    $message = 'File successfully found and ready for download.';
                    $success = true;

                    // Return the file with appropriate headers
                    return response()->download($filePath, $fileName, [
                        'Content-Type' => 'application/octet-stream',
                        'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
                    ]);
                }

                // If more than one file, create a zip file
                $zipFileName = 'submissions.zip';
                $zipFilePath = public_path($zipFileName);

                // Create a new ZIP file
                $zip = new ZipArchive();
                if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
                    foreach ($files as $file) {
                        $zip->addFile($file, basename($file)); // Add file to zip with its original name
                    }
                    $zip->close();

                    return response()->download($zipFilePath, $zipFileName, [
                        'Content-Type' => 'application/zip',
                        'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"'
                    ])->deleteFileAfterSend(true);
                } else {
                    $message = 'Unable to create zip file.';
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                        'data' => $data
                    ], 500);
                }

            } catch (\Exception $e) {
                // Handle any exception that occurs during the process
                return response()->json([
                    'success' => false,
                    'message' => 'Error downloading submission: ' . $e->getMessage(),
                    'data' => $data
                ], 500);
            }
        }

        // Token validation failed
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], 401); // Unauthorized response
    }
   
}
