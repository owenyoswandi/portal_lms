<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_subtopic;
use App\Models\tbl_subtopic_test;
use App\Models\tbl_pertanyaan;
use App\Models\tbl_hasil_test;
use App\Models\tbl_hasil_test_detail;
use App\Models\tbl_pilihan_jawaban;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    /**
    *    @OA\Get(
    *       path="/subtopic_test_jawaban-byid/{subtopic_id}",
    *       tags={"SubtopicTest"},
    *       operationId="listSubtopicTestJawabanById",
    *       summary="SubtopicTestJawaban - Get By Id",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID",
	*     example="1",
	*     in="path",
	*     name="subtopic_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data SubtopicTest Berdasarkan ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data SubtopicTest",
    *               "data": {
    *                   {
	*					  "pertanyaan_id": 1,
	*					  "teks_pertanyaan": "Pengolahan Data yang dikelola secara otomatis oleh mesin dan mempelajari semua pola sesuai dari data yang tersedia adalah",
	*					  "tipe_pertanyaan": "pilihan_ganda"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listSubtopicTestJawabanById($subtopic_id) {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;
    
            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data SubtopicTestJawaban';
    
                // Get subtopic data
                $subtopic = tbl_subtopic::find($subtopic_id);
    
                // Step 1: First fetch all the questions (with or without shuffle)
                $query = tbl_subtopic_test::join('tbl_pertanyaan', 'tbl_subtopic_test.test_pertanyaan_id', '=', 'tbl_pertanyaan.pertanyaan_id')
                    ->where('tbl_subtopic_test.test_st_id', '=', $subtopic_id)
                    ->select('tbl_pertanyaan.pertanyaan_id', 'tbl_pertanyaan.teks_pertanyaan', 'tbl_pertanyaan.tipe_pertanyaan');
    
                // If shuffle is enabled, limit the questions to 10 random ones
                if ($subtopic && $subtopic->st_is_shuffle == 1) {
                    $shuffleLimit = $subtopic->st_jumlah_shuffle;
                    $query = $query->inRandomOrder()->limit($shuffleLimit);
                }
    
                // Step 2: Get the questions
                $questions = $query->get();
    
                // Step 3: Get all answer choices for the selected questions
                $answerChoices = tbl_pilihan_jawaban::whereIn('pertanyaan_id', $questions->pluck('pertanyaan_id'))
                    ->get();
    
                // Step 4: Format the data by grouping the answer choices under each question
                $formattedData = [];
                foreach ($questions as $question) {
                    $formattedData[$question->pertanyaan_id] = [
                        'pertanyaan_id' => $question->pertanyaan_id,
                        'teks_pertanyaan' => $question->teks_pertanyaan,
                        'tipe_pertanyaan' => $question->tipe_pertanyaan,
                        'pilihan_jawaban' => [],
                    ];
    
                    // Add answer choices to the question
                    $choicesForQuestion = [];
                    foreach ($answerChoices as $choice) {
                        if ($choice->pertanyaan_id == $question->pertanyaan_id) {
                            $choicesForQuestion[] = [
                                'pilihan_id' => $choice->pilihan_id,
                                'teks_pilihan' => $choice->teks_pilihan,
                            ];
                        }
                    }
    
                    // Shuffle the answer choices
                    $shuffledChoices = collect($choicesForQuestion)->shuffle();
    
                    // Add shuffled choices to the formatted data
                    $formattedData[$question->pertanyaan_id]['pilihan_jawaban'] = $shuffledChoices->values()->all();
                }
    
                // Convert the formatted data to an array
                $formattedData = array_values($formattedData);
            }
    
            // Return the data in JSON format
            return response()->json([
                'success' => $success,
                'message' => $message,
                'data'    => $formattedData,
            ], 200);
    
        } catch (QueryException $e) {
            // Handle errors
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    
    /**
    *    @OA\Get(
    *       path="/subtopic_test-byid/{subtopic_id}",
    *       tags={"SubtopicTest"},
    *       operationId="listSubtopicTestById",
    *       summary="SubtopicTest - Get By Id",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID",
	*     example="1",
	*     in="path",
	*     name="subtopic_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data SubtopicTest Berdasarkan ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data SubtopicTest",
    *               "data": {
    *                   {
	*					  "pertanyaan_id": 1,
    *					  "course_id": 1,
	*					  "teks_pertanyaan": "Pengolahan Data yang dikelola secara otomatis oleh mesin dan mempelajari semua pola sesuai dari data yang tersedia adalah",
	*					  "tipe_pertanyaan": "pilihan_ganda"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listSubtopicTestById($subtopic_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data SubtopicTest';
                $data = tbl_subtopic_test::select('*')
                    ->join('tbl_pertanyaan', 'tbl_subtopic_test.test_pertanyaan_id', '=', 'tbl_pertanyaan.pertanyaan_id')
                    ->where('tbl_subtopic_test.test_st_id', '=',  $subtopic_id)
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
     *   path="/subtopic_test_question-byid/{subtopic_id}/{course_id}",
     *   tags={"SubtopicTest"},
     *   operationId="listSubtopicTestQuestionById",
     *   summary="SubtopicTest - Get All Right Join Pertanyaan",
     *   security={{ "bearerAuth": {} }},
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan ID",
     *     example="1",
     *     in="path",
     *     name="subtopic_id",
     *     required=true,
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(
     *       default="1",
     *       type="string",
     *     ),
     *     description="Masukan ID",
     *     example="1",
     *     in="path",
     *     name="course_id",
     *     required=true,
     *   ),
     *   description="Mengambil Data SubtopicTest Berdasarkan ID",
     *   @OA\Response(
     *     response="200",
     *     description="Ok",
     *     @OA\JsonContent(
     *       example={
     *         "success": true,
     *         "message": "Berhasil mengambil Data SubtopicTest",
     *         "data": {
     *           {
     *             "pertanyaan_id": 1,
     *             "course_id": 1,
     *             "teks_pertanyaan": "Pengolahan Data yang dikelola secara otomatis oleh mesin dan mempelajari semua pola sesuai dari data yang tersedia adalah",
     *             "tipe_pertanyaan": "pilihan_ganda"
     *           }
     *         }
     *       }
     *     ),
     *   ),
     * )
     */
    public function listSubtopicTestQuestionById($subtopic_id, $course_id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            // Mengecek token
            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data SubtopicTest';

                // Mengambil data pertanyaan yang belum ada di subtopic_test
                $data = tbl_pertanyaan::select('tbl_pertanyaan.*')
                    ->leftJoin('tbl_subtopic_test', function ($join) use ($subtopic_id) {
                        $join->on('tbl_pertanyaan.pertanyaan_id', '=', 'tbl_subtopic_test.test_pertanyaan_id')
                            ->where('tbl_subtopic_test.test_st_id', '=', $subtopic_id);  // Menyaring berdasarkan test_st_id
                    })
                    ->where('tbl_pertanyaan.course_id', '=',  $course_id)
                    ->whereNull('tbl_subtopic_test.test_pertanyaan_id')  // Menampilkan pertanyaan yang belum ada di subtopic_test
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
    *     path="/subtopic_test/create",
    *     tags={"SubtopicTest"},
    *     operationId="insertSubtopicTest",
    *     summary="SubtopicTest - Create",
    *     description="Create new SubtopicTest",
    *     security={{ "bearerAuth": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 required={"test_st_id","test_pertanyaan_id"},
    *                 @OA\Property(property="test_st_id", type="string", example="1"),
    *                 @OA\Property(property="test_pertanyaan_id", type="string", example="1")
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
    public function insertSubtopicTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_st_id' => 'required'
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
                // Get the submission IDs from the request
                $pertanyaanIds = json_decode($request->input('pertanyaanIds'));
                $stId = $request->input('test_st_id');

                // Ensure that submission IDs are provided
                if (empty($pertanyaanIds)) {
                    $message = 'No quetions selected.';
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                        'data' => $data
                    ], 400);
                }
                foreach ($pertanyaanIds as $id) {
                    $data = tbl_subtopic_test::create([
                        'test_st_id' => $stId,
                        'test_pertanyaan_id' => $id
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
    * @OA\Delete(
    *     path="/subtopic-test/delete",
    *     tags={"SubtopicTest"},
    *     operationId="deleteSubtopicTest",
    *     summary="SubtopicTest - Delete",
    *     description="Delete SubtopicTest data",
    *     security={{ "bearerAuth": {} }},
    *    	@OA\RequestBody(
    *         required=true,
    *         description="Request Body Description",
    *         @OA\JsonContent(
    *             example={
    *				"test_st_id": "1",
    *				"test_pertanyaan_id": "1",
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
    *  				    "test_st_id": "1",
    *  				    "test_pertanyaan_id": "1",
    *				},
    *         })
    *     )
    * )
    */
    public function deleteSubtopicTest(Request $request)
    {
        $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;

        if ($this->checkToken($token)) {
            try {
                $subtopic_test = tbl_subtopic_test::where('test_st_id', $request->input("test_st_id"))
                    ->where('test_pertanyaan_id', $request->input("test_pertanyaan_id"))
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
    *       path="/hasil_test-byuser-subtopicid/{subtopic_id}/{user_id}",
    *       tags={"HasilTest"},
    *       operationId="listHasilTestByUserStId",
    *       summary="HasilTest - Get By Subtopic and User ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID Subtopic",
	*     example="1",
	*     in="path",
	*     name="subtopic_id",
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
    *       description="Mengambil Data Hasil Test Berdasarkan Subtopic dan User ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Hasil Test",
    *               "data": {
    *                   {
    *						"hasil_id": "1",
    *						"hasil_subtopic_id": "1",
    *						"hasil_peserta_id": "1",
    *						"waktu_respon": "2024-03-12"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listHasilTestByUserStId($st_id, $user_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
            $result = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Hasil Test';

                $testResults = tbl_hasil_test::where('peserta_id', $user_id)
                    ->whereIn('subtopic_id', [$st_id])
                    ->get();

                    // Determine the status (Never Submitted or Finished)
                $status = $testResults->isEmpty() ? 'Never Submitted' : 'Finished';

                // If the participant has completed the test, process the results
                if ($status === 'Finished') {
                    $i = 1;
                    foreach ($testResults as $testResult) {
                        $participantData = [
                            'hasil_id' => $testResult->hasil_id,
                            'waktu_respon' => $testResult->waktu_respon,
                            'status' => "{$status} / Attempt {$i}",
                            'total_score' => 0,
                            'total_bobot' => 0,
                        ];

                        $totalCorrectAnswers = 0;
                        $totalBobotQuestions = 0;

                        // Fetch details for this test attempt, joining with tbl_subtopic_test to get question data
                        $testResultDetails = tbl_hasil_test_detail::where('hasil_id', $testResult->hasil_id)
                            ->join('tbl_subtopic_test', 'tbl_hasil_test_detail.pertanyaan_id', '=', 'tbl_subtopic_test.test_pertanyaan_id')
                            ->join('tbl_pertanyaan', 'tbl_subtopic_test.test_pertanyaan_id', '=', 'tbl_pertanyaan.pertanyaan_id')
                            ->where('tbl_subtopic_test.test_st_id', $st_id)
                            ->get();

                        // Loop through each test result detail and check answers
                        foreach ($testResultDetails as $testResultDetail) {
                            $questionId = $testResultDetail->pertanyaan_id;
                            $isCorrect = 0;  // Default to incorrect if no answer found
                            $bobot = 0;      // Default value for bobot in case no value is set

                            // Check if there's an answer for the question
                            if ($testResultDetail->jawaban_id) {
                                // Get the choice related to the answer and check if it's correct
                                $choice = tbl_pilihan_jawaban::find($testResultDetail->jawaban_id);
                                if ($choice) {
                                    $isCorrect = $choice->maks_nilai;  // Correct answer score
                                } else {
                                    // If no choice, check if it's an open answer (isian)
                                    $isCorrect = $testResultDetail->nilai_jawaban_isian ?? 0;
                                }
                            }

                            // Get bobot (weight) from the question
                            $bobot = $testResultDetail->maks_nilai;

                            // Aggregate the total score and weight
                            $totalCorrectAnswers += $isCorrect;
                            $totalBobotQuestions += $bobot;
                        }

                        // Calculate total score (correct answers divided by total weight, multiplied by 100)
                        // $participantData['total_score'] = $totalBobotQuestions > 0 ? ($totalCorrectAnswers / $totalBobotQuestions) * 100 : 0;
                        $participantData['total_score'] = $totalBobotQuestions > 0 ? $totalCorrectAnswers : 0;
                        $participantData['total_bobot'] = $totalBobotQuestions;

                        // Add participant data to the result array
                        $result[] = $participantData;
                        $i++;
                    }
                }

			}
			
			//make response JSON
			return response()->json([
				'success' => $success,
				'message' => $message,
				'data'    => $result
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
    *       path="/hasil_test-bysubtopicid/{subtopic_id}",
    *       tags={"HasilTest"},
    *       operationId="listHasilTestByStId",
    *       summary="HasilTest - Get By Subtopic ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID Subtopic",
	*     example="1",
	*     in="path",
	*     name="subtopic_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Hasil Test Berdasarkan Subtopic ID",
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "Berhasil mengambil Data Hasil Test",
    *               "data": {
    *                   {
    *						"hasil_id": "1",
    *						"hasil_subtopic_id": "1",
    *						"hasil_peserta_id": "1",
    *						"waktu_respon": "2024-03-12"
	*					}
    *              }
    *          }),
    *      ),
    *  )
    */
    public function listHasilTestByStId($st_id) {
		try {
			$token = request()->bearerToken();
			$success = false;
			$message = "Authorization Failed";
			$data = null;
			
			if ($this->checkToken($token)) {
				$success = true;
				$message = 'Berhasil mengambil Data Hasil Test';

                $data = tbl_hasil_test::select('*')
                ->where([
					['subtopic_id', '=', $st_id]
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
    * @OA\Post(
    *     path="/hasil-test",
    *     tags={"HasilTest"},
    *     operationId="createHasilTest",
    *     summary="HasilTest - Create",
    *     description="Create new HasilTest",
    *     security={{ "bearerAuth": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 required={"peserta_id","subtopic_id","waktu_respon"},
    *                 @OA\Property(property="peserta_id", type="string", example="1"),
    *                 @OA\Property(property="subtopic_id", type="string", example="1"),
    *                 @OA\Property(property="waktu_respon", type="string", format="date-time")
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
            'peserta_id' => 'required',
            'subtopic_id' => 'required'
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
                $data = tbl_hasil_test::create([
                    'peserta_id' => $request->peserta_id,
                    'subtopic_id' => $request->subtopic_id,
                    'waktu_respon' => $request->waktu_respon
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
    *     path="/hasil-test/{id}",
    *     tags={"HasilTest"},
    *     operationId="getHasilTest",
    *     summary="HasilTest - Get By ID",
    *     description="Get HasilTest data by ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="hasil ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data HasilTest",
    *             "data": {
    *                     "hasil_id": 1,
    *                     "peserta_id": 1,
    *                     "subtopic_id": 1,
    *                     "waktu_respon": "2024-01-14 10:00:00"
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
                $message = 'Berhasil mengambil Data hasil test';
                $data = tbl_hasil_test::join('tbl_subtopic', 'tbl_hasil_test.subtopic_id', '=', 'tbl_subtopic.st_id')
                ->select('tbl_hasil_test.*', 'tbl_subtopic.st_duration')
				->where([
					['tbl_hasil_test.hasil_id', '=', $id]
				])->first();
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
    *     path="/hasil-test/{id}",
    *     tags={"HasilTest"},
    *     operationId="updateHasilTest",
    *     summary="HasilTest - Update",
    *     description="Update HasilTest data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="hasil ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(property="_method", type="string", example="PUT", description="Need to be PUT"),
    *                 @OA\Property(property="peserta_id", type="string", example="1"),
    *                 @OA\Property(property="subtopic_id", type="string", example="1"),
    *                 @OA\Property(property="waktu_respon", type="string", format="date-time"),
    *                 @OA\Property(property="waktu_submit", type="string", format="date-time")
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
                $data = tbl_hasil_test::findOrFail($id);

                $data->update($request->all());
                
                $success = true;
                $message = 'Data berhasil diubah';
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
}
