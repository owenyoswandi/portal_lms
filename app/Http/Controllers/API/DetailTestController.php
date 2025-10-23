<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_hasil_test_detail;
use App\Models\tbl_user;
use App\Models\tbl_hasil_test;
use App\Models\tbl_subtopic_test;
use App\Models\tbl_pertanyaan;
use App\Models\tbl_pilihan_jawaban;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class DetailTestController extends Controller
{

    /**
    *    @OA\Get(
    *       path="/detail-test-bysubtopicid/{subtopic_id}",
    *       tags={"DetailTest"},
    *       operationId="getAllDetailTestBySubtopic",
    *       summary="HasilTestDetail - Get By Subtopic ID",
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

    public function getAllDetailTestBySubtopic($subtopic_id)
    {
        try {
            $token = request()->bearerToken();
            
            if (!$this->checkToken($token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authorization Failed',
                    'data'    => null
                ], 401);
            }

            // Get all participants
            $participants = tbl_user::join('tbl_transaction', 'tbl_user.user_id', '=', 'tbl_transaction.t_user_id')
                ->join('tbl_product', 'tbl_transaction.t_p_id', '=', 'tbl_product.p_id')
                ->join('tbl_topic', 'tbl_product.p_id', '=', 'tbl_topic.t_p_id')
                ->join('tbl_subtopic', 'tbl_topic.t_id', '=', 'tbl_subtopic.st_t_id')
                ->where('tbl_subtopic.st_id', $subtopic_id)
                ->get();

            // Preload subtopic questions
            $subtopicQuestions = tbl_subtopic_test::join('tbl_pertanyaan', 'tbl_subtopic_test.test_pertanyaan_id', '=', 'tbl_pertanyaan.pertanyaan_id')
                ->where('tbl_subtopic_test.test_st_id', $subtopic_id)
                ->get();

            $result = [];

            foreach ($participants as $participant) {
                $testResults = tbl_hasil_test::where('peserta_id', $participant->user_id)
                    ->where('subtopic_id', $subtopic_id)
                    ->get();

                $status = $testResults->isEmpty() ? 'Never Submitted' : 'Finished';

                // Initialize participant data
                $participantData = [
                    'hasil_id' => null,
                    'waktu_respon' => null,
                    'waktu_submit' => null,
                    'nama' => $participant->nama,
                    'email' => $participant->email,
                    'status' => $status,
                    'jawaban' => [],
                    'total_score' => 0,
                    'total_bobot_questions' => 0
                ];

                if ($status === 'Finished') {
                    $i = 1;
                    foreach ($testResults as $testResult) {
                        $participantData['jawaban'] = [];
                        $participantData['status'] = "{$status} / Attempt {$i}";
                        $participantData['hasil_id'] = $testResult->hasil_id;
                        $participantData['waktu_respon'] = $testResult->waktu_respon;
                        $participantData['waktu_submit'] = $testResult->waktu_submit;

                        // Get all test details for this result
                        $testResultDetails = tbl_hasil_test_detail::where('hasil_id', $testResult->hasil_id)->get();

                        $totalCorrectAnswers = 0;
                        $totalBobotQuestions = 0;

                        // Loop through each subtopic question
                        foreach ($subtopicQuestions as $question) {
                            $id = $question->test_pertanyaan_id;
                            $bobot = $question->maks_nilai;

                            // Find corresponding test result detail for the question
                            $testResultDetail = $testResultDetails->firstWhere('pertanyaan_id', $id);
                            $isCorrect = 0;  // Default to incorrect if no answer found

                            if ($testResultDetail) {
                                $choice = tbl_pilihan_jawaban::find($testResultDetail->jawaban_id);
                                if ($choice) {
                                    $isCorrect = $choice->maks_nilai;
                                } else {
                                    $isCorrect = $testResultDetail->nilai_jawaban_isian ?: 0;
                                }
                            }

                            // Add the answer details to the participant data
                            $participantData['jawaban'][] = [
                                'hasil_id_detail' => $testResultDetail->hasil_id_detail ?? 0,
                                'tipe_pertanyaan' => $question->tipe_pertanyaan,
                                'score' => $isCorrect,
                                'bobot' => $bobot
                            ];

                            // Aggregate the total score and weight
                            $totalCorrectAnswers += $isCorrect;
                            $totalBobotQuestions += $bobot;
                        }

                        // Calculate total score
                        $participantData['total_score'] = $totalBobotQuestions > 0 ? $totalCorrectAnswers : 0;
                        $participantData['total_bobot_questions'] = $totalBobotQuestions;

                        // Add participant data to the result array
                        $result[] = $participantData;
                        $i++;
                    }
                } else {
                    $result[] = $participantData;
                }
            }

            // Return the response with all participants and their test details
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil Data Hasil Test',
                'data'    => $result
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
    *    @OA\Get(
    *       path="/detail-test-bysubtopicidshuffle/{subtopic_id}",
    *       tags={"DetailTest"},
    *       operationId="getShuffleDetailTestBySubtopic",
    *       summary="ShuffleHasilTestDetail - Get By Subtopic ID",
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

    public function getShuffleDetailTestBySubtopic($subtopic_id) 
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            // Validate token
            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data Hasil Test';
                
                // Get all participants who have taken the test for the given subtopic
                $participants = tbl_user::join('tbl_transaction', 'tbl_user.user_id', '=', 'tbl_transaction.t_user_id')
                    ->join('tbl_product', 'tbl_transaction.t_p_id', '=', 'tbl_product.p_id')
                    ->join('tbl_topic', 'tbl_product.p_id', '=', 'tbl_topic.t_p_id')
                    ->join('tbl_subtopic', 'tbl_topic.t_id', '=', 'tbl_subtopic.st_t_id')
                    ->where('tbl_subtopic.st_id', $subtopic_id)
                    ->get();

                $result = [];

                // Loop through participants
                foreach ($participants as $participant) {
                    // Get all test results for the participant for the given subtopic
                    $testResults = tbl_hasil_test::where('peserta_id', $participant->user_id)
                        ->whereIn('subtopic_id', [$subtopic_id])  // Ensure test results are for the correct subtopic
                        ->get();

                    // Determine the status (Never Submitted or Finished)
                    $status = $testResults->isEmpty() ? 'Never Submitted' : 'Finished';

                    // Initialize participantData to null for each test result
                    $participantData = [
                        'hasil_id' => null,
                        'waktu_respon' => null,
                        'waktu_submit' => null,
                        'nama' => $participant->nama,
                        'email' => $participant->email,
                        'status' => $status,
                        'jawaban' => [],      // Array to store answers
                        'total_score' => 0,    // Total score for the participant
                        'total_bobot_questions' => 0    // Total question weight
                    ];

                    // If the participant has completed the test, process the results
                    if ($status === 'Finished') {
                        $i = 1;
                        foreach ($testResults as $testResult) {
                            $participantData['jawaban'] = [];
                            $totalCorrectAnswers = 0;
                            $totalBobotQuestions = 0;

                            // Fill in the participant's test result details
                            $participantData['status'] = "{$status} / Attempt {$i}";
                            $participantData['hasil_id'] = $testResult->hasil_id;
                            $participantData['waktu_respon'] = $testResult->waktu_respon;
                            $participantData['waktu_submit'] = $testResult->waktu_submit;
                            
                            $testResultDetails = tbl_hasil_test_detail::where('hasil_id', $testResult->hasil_id)
                            ->join('tbl_subtopic_test', 'tbl_hasil_test_detail.pertanyaan_id', '=', 'tbl_subtopic_test.test_pertanyaan_id')
                            ->join('tbl_pertanyaan', 'tbl_subtopic_test.test_pertanyaan_id', '=', 'tbl_pertanyaan.pertanyaan_id')
                            ->where('tbl_subtopic_test.test_st_id', $subtopic_id)
                            ->orderBy('tbl_hasil_test_detail.hasil_id_detail', 'asc') // or 'desc' depending on the required sorting order
                            ->get();

                            // Loop through each test result detail and check answers
                            foreach ($testResultDetails as $testResultDetail) {
                                $id = $testResultDetail->pertanyaan_id;
                                // Get bobot (weight) from the question
                                $bobot = $testResultDetail->maks_nilai;
                                $isCorrect = 0;  // Default to incorrect if no answer found
                                $idDetail = $testResultDetail->hasil_id_detail;

                                if ($testResultDetail->jawaban_id) {
                                    $choice = tbl_pilihan_jawaban::find($testResultDetail->jawaban_id);
                                    if($choice){
                                        $isCorrect =  $choice->maks_nilai;
                                    } else {
                                        // If no choice, check if it's an open answer (isian)
                                        $isCorrect = $testResultDetail->nilai_jawaban_isian ?? 0;
                                    }
                                }

                                // Add the answer details to the participant data
                                $participantData['jawaban'][] = [
                                    'hasil_id_detail' => $idDetail,
                                    'pertanyaan_id' => $testResultDetail->pertanyaan_id,
                                    'tipe_pertanyaan' => $testResultDetail->tipe_pertanyaan,
                                    'score' => $isCorrect,
                                    'bobot' => $bobot
                                ];

                                // Aggregate the total score and weight
                                $totalCorrectAnswers += $isCorrect;
                                $totalBobotQuestions += $bobot;
                            }

                            // Calculate total score (correct answers divided by total weight, multiplied by 100)
                            // $participantData['total_score'] = $totalBobotQuestions > 0 ? ($totalCorrectAnswers / $totalBobotQuestions) * 100 : 0;
                            $participantData['total_score'] = $totalBobotQuestions > 0 ? $totalCorrectAnswers : 0;
                            $participantData['total_bobot_questions'] = $totalBobotQuestions;

                            // Add participant data to the result array
                            $result[] = $participantData;
                            $i++;
                        }
                    } else{
                        $result[] = $participantData;
                    }
                    
                }

                // Return response with results
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                    'data'    => $result
                ], 200);
            }

            // Return authorization failed response
            return response()->json([
                'success' => $success,
                'message' => $message,
                'data'    => $data
            ], 401);

        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }


    /**
    *    @OA\Get(
    *       path="/detail-test-byhasilid/{hasil_id}",
    *       tags={"DetailTest"},
    *       operationId="getAllDetailTestByHasil",
    *       summary="HasilTestDetail - Get By Hasil ID",
	*		security={{ "bearerAuth": {} }},
	*   @OA\Parameter(
	*     @OA\Schema(
	*       default="1",
	*       type="string",
	*     ),
	*     description="Masukan ID Hasil",
	*     example="1",
	*     in="path",
	*     name="hasil_id",
	*     required=true,
	*   ),
    *       description="Mengambil Data Hasil Test Berdasarkan Hasil ID",
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

    public function getAllDetailTestByHasil($hasil_id)
    {
        try {
            $token = request()->bearerToken();

            // Validate token
            if (!$this->checkToken($token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authorization Failed',
                    'data'    => null
                ], 401);
            }

            // Retrieve the test result for the given hasil_id
            $hasil = tbl_hasil_test::join('tbl_user', 'tbl_hasil_test.peserta_id', '=', 'tbl_user.user_id')
                ->join('tbl_subtopic', 'tbl_hasil_test.subtopic_id', '=', 'tbl_subtopic.st_id')
                ->where('tbl_hasil_test.hasil_id', $hasil_id)
                ->first();

            if (!$hasil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Hasil Test tidak ditemukan',
                    'data'    => null
                ], 404);
            }

            // Initialize the response data structure
            $detailData = [
                'hasil_id' => $hasil->hasil_id,
                'waktu_respon' => $hasil->waktu_respon,
                'nama' => $hasil->nama,
                'email' => $hasil->email,
                'status' => 'Finished',
                'pertanyaan' => [],
                'total_score' => 0,
                'total_bobot_questions' => 0
            ];

            $totalCorrectAnswers = 0;
            $totalBobotQuestions = 0;

            // Fetch test result details
            $testResultDetails = tbl_hasil_test_detail::where('hasil_id', $hasil_id)->get();
            
            // Get related questions based on shuffle status
            $questionsQuery = $hasil->st_is_shuffle == 1
                ? tbl_hasil_test_detail::where('hasil_id', $hasil_id)
                    ->join('tbl_subtopic_test', 'tbl_hasil_test_detail.pertanyaan_id', '=', 'tbl_subtopic_test.test_pertanyaan_id')
                    ->join('tbl_pertanyaan', 'tbl_subtopic_test.test_pertanyaan_id', '=', 'tbl_pertanyaan.pertanyaan_id')
                    ->where('tbl_subtopic_test.test_st_id', $hasil->subtopic_id)
                    ->orderBy('tbl_hasil_test_detail.hasil_id_detail', 'asc') // or 'desc'
                    ->get() // only shuffle/detail hasil test
                : tbl_subtopic_test::join('tbl_pertanyaan', 'tbl_subtopic_test.test_pertanyaan_id', '=', 'tbl_pertanyaan.pertanyaan_id')
                    ->where('tbl_subtopic_test.test_st_id', $hasil->subtopic_id)
                    ->select('tbl_pertanyaan.*')
                    ->get(); // all question

            // Loop through questions and calculate scores
            foreach ($questionsQuery as $question) {
                $choices = tbl_pilihan_jawaban::where('pertanyaan_id', $question->pertanyaan_id)->get();
                $testResultDetail = $testResultDetails->firstWhere('pertanyaan_id', $question->pertanyaan_id);

                $userAnswerId = $testResultDetail ? $testResultDetail->jawaban_id : null;
                $essay = $testResultDetail ? $testResultDetail->jawaban_isian : null;

                // Calculate score
                $isCorrect = 0;
                $finalScore = 0;
                $bobot = $question->maks_nilai;

                if ($testResultDetail) {
                    $choice = tbl_pilihan_jawaban::find($testResultDetail->jawaban_id);
                    if ($choice) {
                        $isCorrect = $choice->is_jawaban_benar ? 1 : 0;
                        $finalScore = $choice->maks_nilai;
                    } else {
                        $finalScore = $testResultDetail->nilai_jawaban_isian ?: 0;
                    }
                }

                // Update total scores
                $totalCorrectAnswers += $finalScore;
                $totalBobotQuestions += $bobot;

                // Prepare question data
                $questionData = [
                    'pertanyaan_id' => $question->pertanyaan_id,
                    'teks_pertanyaan' => $question->teks_pertanyaan,
                    'tipe_pertanyaan' => $question->tipe_pertanyaan,
                    'pilihan_jawaban' => $choices->map(function ($choice) use ($userAnswerId) {
                        return [
                            'pilihan_id' => $choice->pilihan_id,
                            'teks_pilihan' => $choice->teks_pilihan,
                            'is_checked' => $userAnswerId == $choice->pilihan_id,
                            'is_jawaban_benar' => $choice->is_jawaban_benar
                        ];
                    }),
                    'jawaban_benar' => $choices->firstWhere('is_jawaban_benar', true) ? [
                        'pilihan_id' => $choices->firstWhere('is_jawaban_benar', true)->pilihan_id,
                        'teks_pilihan' => $choices->firstWhere('is_jawaban_benar', true)->teks_pilihan
                    ] : null,
                    'isCorrect' => $isCorrect,
                    'essay' => $essay === "NULL" ? null : $essay,
                    'score' => $finalScore,
                    'maks_nilai' => $bobot
                ];

                // Add question data to the response
                $detailData['pertanyaan'][] = $questionData;
            }

            // Calculate total score
            $detailData['total_score'] = $totalBobotQuestions > 0 ? $totalCorrectAnswers : 0;
            $detailData['total_bobot_questions'] = $totalBobotQuestions;

            // Return the response
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil Data Hasil Test',
                'data'    => [$detailData]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }        

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
    * @OA\Post(
    *     path="/detail-test",
    *     tags={"DetailTest"},
    *     operationId="createDetailTest",
    *     summary="DetailTest - Create",
    *     description="Create new DetailTest",
    *     security={{ "bearerAuth": {} }},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 required={"hasil_id_detail","hasil_id","pertanyaan_id"},
    *                 @OA\Property(property="hasil_id_detail", type="string", example="1"),
    *                 @OA\Property(property="hasil_id", type="string", example="1"),
    *                 @OA\Property(property="pertanyaan_id", type="string", example="1")
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
            'hasil_id' => 'required',
            'pertanyaan_id' => 'required'
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
                $data = tbl_hasil_test_detail::where('hasil_id', $request->hasil_id)
                        ->where('pertanyaan_id', $request->pertanyaan_id)
                        ->first();
                        
                if($data){
                    $data->update($request->all());
                } else {
                    $data = tbl_hasil_test_detail::create([
                        'hasil_id' => $request->hasil_id,
                        'pertanyaan_id' => $request->pertanyaan_id,
                        'jawaban_id' => $request->jawaban_id,
                        'jawaban_isian' => $request->jawaban_isian
                    ]);
                }
                

                $success = true;
                $message = 'Data berhasil disimpan';
            } catch (QueryException $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
    *     path="/detail-test/{id}",
    *     tags={"DetailTest"},
    *     operationId="getDetailTest",
    *     summary="DetailTest - Get By ID",
    *     description="Get DetailTest data by ID",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="DetailTest ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Success",
    *         @OA\JsonContent(example={
    *             "success": true,
    *             "message": "Berhasil mengambil Data DetailTest",
    *             "data": {
    *						"hasil_id_detail": "1",
    *						"hasil_id": "1",
    *						"pertanyaan_id": "1",
    *						"jawaban_id": "1",
    *						"jawaban_isian": "isian"
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
                $message = 'Berhasil mengambil Data DetailTest';
                $data = tbl_hasil_test_detail::findOrFail($id);
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
    *     path="/detail-test/{id}",
    *     tags={"DetailTest"},
    *     operationId="updateDetailTest",
    *     summary="DetailTest - Update",
    *     description="Update DetailTest data",
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="DetailTest ID",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(property="hasil_id_detail", type="string", example="1"),
    *                 @OA\Property(property="jawaban_id", type="string", example="1"),
    *                 @OA\Property(property="jawaban_isian", type="string", example="isian")
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
                $detailtest = tbl_hasil_test_detail::findOrFail($id);

                $detailtest->update($request->all());
                
                $success = true;
                $message = 'Data berhasil diubah';
                $data = $detailtest;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating detailtest: ' . $e->getMessage()
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
