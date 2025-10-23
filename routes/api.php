<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\FeedbackController;

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\ActivityController;
use App\Http\Controllers\API\TransactionController;

use App\Http\Controllers\API\TopicController;
use App\Http\Controllers\API\SubtopicController;
use App\Http\Controllers\API\SubmissionController;
use App\Http\Controllers\API\PertanyaanController;
use App\Http\Controllers\API\PilihanJawabanController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\DetailTestController;
use App\Http\Controllers\API\DetailProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => ['logger']], function () {
	
	Route::get('user', [UserController::class, 'listUser']);
	Route::get('users', [UserController::class, 'userSelect']);
	Route::get('user/{id}', [UserController::class, 'listUserById'])->where('id', '(.*(?:%2F:)?.*)');
	Route::get('user-group/{id}', [UserController::class, 'listUserGroupById'])->where('id', '(.*(?:%2F:)?.*)');
	Route::post('user/create', [UserController::class, 'insertUser']);
	Route::put('user/update', [UserController::class, 'updateUser']);
	Route::delete('user/delete', [UserController::class, 'deleteUser']);
	Route::put('user/changepassword', [UserController::class, 'updatePassword']);
	Route::get('user-role/{role}', [UserController::class, 'listUserByRole']);

	Route::post('auth/checkLogin', [AuthController::class, 'checkLogin']);
	Route::post('auth/register', [AuthController::class, 'register']);

	// Group apis
	Route::apiResource('group', GroupController::class);
	// Feedback apis
	// Route::apiResource('feedback', FeedbackController::class);	
	Route::get('feedback-course/{subtopic_id}/{user_id}', [FeedbackController::class, 'index']);
	Route::get('feedback-course-admin/{subtopic_id}', [FeedbackController::class, 'index2']);
	Route::get('feedback/{id}', [FeedbackController::class, 'show']);
	Route::post('feedback', [FeedbackController::class, 'store']);
	Route::put('feedback', [FeedbackController::class, 'update']);
	Route::delete('feedback/{id}', [FeedbackController::class, 'destroy']);

	// order
	Route::get('order', [OrderController::class, 'listOrder']);
	Route::get('order/{id}', [OrderController::class, 'listOrderById'])->where('id', '(.*(?:%2F:)?.*)');
	Route::get('order-byuserid/{user_id}', [OrderController::class, 'listOrderByUserID']);
	Route::get('order-bycourseid/{p_id_lms}/{user_id}', [OrderController::class, 'getOrderByCourseId']);
	Route::post('order/create', [OrderController::class, 'insertOrder']);
	Route::put('order/update', [OrderController::class, 'updateOrder']);

	// transaction top up saldo
	Route::post('transaction/create-topup', [TransactionController::class, 'insertTopUp']);
	Route::post('transaction/create-ordercourse', [TransactionController::class, 'insertOrderCourse']);
	Route::get('transaction-balance-byuserid/{user_id}', [TransactionController::class, 'getBalanceByUserID']);
	Route::get('transaction-topup-byuserid/{user_id}', [TransactionController::class, 'lastTopUpByUserID']);
	Route::get('transaction-topup-byid/{t_id}', [TransactionController::class, 'lastTopUpByID']);
	Route::post('transaction/confirm-topup', [TransactionController::class, 'confirmTopUp']);
	Route::post('transaction/validate-topup', [TransactionController::class, 'validateTopUp']);
	Route::get('transaction-byuserid/{user_id}', [TransactionController::class, 'getUserFinance']);
	Route::delete('transaction/delete', [TransactionController::class, 'deleteTransaction']);
	Route::get('transaction-topUp', [TransactionController::class, 'listTopUp']);
	Route::get('transaction-course', [TransactionController::class, 'listCourse']);
	Route::get('transaction-course-byuserid/{user_id}', [TransactionController::class, 'listCourseByUserID']);
	
	// product
	Route::get('product-byjenis/{p_jenis}', [ProductController::class, 'listProductByJenis']);
	Route::get('product-byjenisstatus/{p_jenis}/{user_id}', [ProductController::class, 'listProductByJenisStatus']);
	Route::get('product-byjenisstatusgroup/{p_jenis}/{user_id}', [ProductController::class, 'listProductByJenisStatusGroup']);
	// course apis
	Route::apiResource('product', ProductController::class);

	Route::get('topic-subtopic/{p_id}', [TopicController::class, 'getTopicsByCourse']);

	// topic apis
	Route::get('topic-byproductid/{t_p_id}', [TopicController::class, 'listTopicByProductID']);
	Route::apiResource('topic', TopicController::class);

	// subtopic apis
	Route::get('subtopic-bytopicid/{st_t_id}', [SubtopicController::class, 'listSubtopicByTopicID']);
	Route::apiResource('subtopic', SubtopicController::class);

	// submission apis
	Route::post('download-submission',[SubmissionController::class, 'downloadSubmission']);
	Route::get('submission-bytaskUser/{st_id}/{user_id}', [SubmissionController::class, 'listSubmissionBySubtopicUserID']);
	Route::get('submission-bytask/{st_id}', [SubmissionController::class, 'listSubmissionBySubtopicID']);
	
	Route::apiResource('submission', SubmissionController::class);

	//project
	Route::get('project',[ProjectController::class,'index']);
	Route::get('project/{id}',[ProjectController::class,'showById']);
	Route::get('project-by-user/{user_id}', [ProjectController::class, 'showByUser']);
	Route::post('project',[ProjectController::class, 'store']);
	Route::put('project/{id}', [ProjectController::class,'update']);
	Route::put('project-delete/{id}', [ProjectController::class,'softDelete']);
	Route::delete('project/{id}', [ProjectController::class,'destroy']);
	Route::get('/user-tasks/{userId}/{projectId}', [ProjectController::class, 'getUserTasks']);


	//activities
	Route::get('activities/{phase_id}',[ActivityController::class,'index']);
	Route::get('activities-detail/{activity_id}',[ActivityController::class,'showById']);
	Route::get('activities/{phase_id}/{user_id}',[ActivityController::class,'showByUser']);
	Route::post('activities',[ActivityController::class, 'store']);
	Route::put('activity/{id}', [ActivityController::class,'update']);
	Route::delete('activity/{id}', [ActivityController::class,'destroy']);
	Route::put('/activity/{id}/status', [ActivityController::class, 'updateStatus']);

	//pertanyaan
	Route::get('pertanyaan',[PertanyaanController::class,'listPertanyaan']);
	Route::get('pertanyaan/{id}',[PertanyaanController::class,'listPertanyaanById']);
	Route::post('pertanyaan/create',[PertanyaanController::class, 'insertPertanyaan']);
	Route::put('pertanyaan/update', [PertanyaanController::class,'updatePertanyaan']);
	Route::delete('pertanyaan/delete', [PertanyaanController::class,'deletePertanyaan']);
	Route::get('pertanyaan-jawaban/{id}',[PertanyaanController::class,'listPertanyaanJawabanByCourseId']);
	
	//ilihan jawaban
	Route::get('jawaban',[PilihanJawabanController::class,'listJawaban']);
	Route::get('jawaban/{id}',[PilihanJawabanController::class,'listJawabanById']);
	Route::post('jawaban/create',[PilihanJawabanController::class, 'insertJawaban']);
	Route::put('jawaban/update', [PilihanJawabanController::class,'updateJawaban']);
	Route::delete('jawaban/delete', [PilihanJawabanController::class,'deleteJawaban']);

	//subtopic-test
	Route::get('subtopic_test-byid/{subtopic_id}',[TestController::class,'listSubtopicTestById']);
	Route::get('subtopic_test_question-byid/{subtopic_id}/{course_id}',[TestController::class,'listSubtopicTestQuestionById']);
	Route::get('subtopic_test_jawaban-byid/{subtopic_id}',[TestController::class,'listSubtopicTestJawabanById']);
	Route::get('hasil_test-byuser-subtopicid/{subtopic_id}/{user_id}',[TestController::class,'listHasilTestByUserStId']);
	Route::post('subtopic_test/create',[TestController::class, 'insertSubtopicTest']);
	Route::delete('subtopic_test/delete',[TestController::class, 'deleteSubtopicTest']);

	//hasil test
	Route::get('hasil_test-bysubtopicid/{subtopic_id}',[TestController::class,'listHasilTestByStId']);
	Route::get('hasil_test-byuser-subtopicid/{subtopic_id}/{user_id}',[TestController::class,'listHasilTestByUserStId']);
	Route::apiResource('hasil-test', TestController::class);
	//detail test
	Route::get('detail-test-bysubtopicid/{subtopic_id}',[DetailTestController::class, 'getAllDetailTestBySubtopic']);
	Route::get('detail-test-bysubtopicidshuffle/{subtopic_id}',[DetailTestController::class, 'getShuffleDetailTestBySubtopic']);
	Route::get('detail-test-byhasilid/{hasil_id}',[DetailTestController::class, 'getAllDetailTestByHasil']);
	Route::apiResource('detail-test', DetailTestController::class);

	// profiling
	Route::get('detail-profile', [DetailProfileController::class, 'listDetailProfile']);
	Route::get('detail-profile/{id}', [DetailProfileController::class, 'listDetailProfileById'])->where('id', '(.*(?:%2F:)?.*)');
	Route::post('detail-profile/create', [DetailProfileController::class, 'insertDetailProfile']);
	Route::put('detail-profile/update', [DetailProfileController::class, 'updateDetailProfile']);

	//group api
	Route::get('group_access-byid/{group_id}',[GroupController::class,'listGroupAccessById']);
	Route::get('group_access_courses-byid/{group_id}',[GroupController::class,'listGroupAccessCoursesById']);
	Route::post('group_access/create',[GroupController::class, 'insertGroupAccess']);
	Route::delete('group_access/delete',[GroupController::class, 'deleteGroupAccess']);

	Route::get('group_member-byid/{group_id}',[GroupController::class,'listGroupMemberById']);
});
