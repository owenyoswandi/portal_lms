<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\AgendaHarianController;
use App\Http\Controllers\user\KondisiHarianController;
use App\Http\Controllers\user\KonsumsiObatController;
use App\Http\Controllers\user\RencanaKondisiKesehatanController;
use App\Http\Controllers\user\RencanaKunjunganController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\user\DokterController;
use App\Http\Controllers\user\HasilPemeriksaanController;
use App\Http\Controllers\user\PerawatClinicController;
use App\Http\Controllers\user\PerawatHomeCareController;
use App\Http\Controllers\user\RiwayatMedisController;

use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberCardController;
use App\Http\Controllers\admin\BankSoalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password');

Route::group(['middleware' => 'checkToken'], function () {
    // user
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/user-profile', [UserController::class, 'index'])->name('user-profile');
    Route::get('/user-profile-dtl', [UserController::class, 'profileDetail'])->name('user-profile-dtl');
    Route::post('/user-profile/post', [UserController::class, 'index'])->name('user-profile-post');
    Route::get('/show-notifikasi', [UserController::class, 'showNotifPage'])->name('show-notifikasi');
    Route::get('/user-profile-edit', [UserController::class, 'showEditUserProfileForm'])->name('user-profile-edit');
    Route::get('/user-profile-edit-general', [UserController::class, 'showEditUserGeneral'])->name('user-profile-edit-general');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');

	Route::get('/admin-pengguna', [AdminController::class, 'index'])->name('admin-pengguna');
    Route::get('/admin-group', [AdminController::class, 'adminGroup'])->name('admin-group');
    Route::get('/admin/order', [AdminController::class, 'order']);
    Route::get('/admin/topup', [AdminController::class, 'topup']);
    Route::get('/admin/downloadFile/{folder}/{filename}', [AdminController::class, 'downloadFile']);
    Route::get('/admin/course', [AdminController::class, 'course'])->name('admin.course');
    Route::get('/admin/view_course/{id}', [AdminController::class, 'view_course'])->name('admin.viewcourse');
    Route::get('/admin/view_course/{id}/{t_id}', [AdminController::class, 'view_subtopic']);
    Route::get('/admin/view_course/{id}/{st_id}/{sm_id}', [AdminController::class, 'grading']);
    Route::get('/admin/view_test/{id}/{st_id}', [AdminController::class, 'view_test']);
    Route::get('/admin/review/{id}/{st_id}/{hasil_id}', [AdminController::class, 'review']);
    Route::get('/admin/course/topic/{id}', [AdminController::class, 'topic']);
    Route::get('/admin/course/topic/{id}/{t_id}', [AdminController::class, 'subtopic']);
    Route::get('/admin/course/topic/{id}/{t_id}/{st_id}', [AdminController::class, 'subtopic_test']);
    Route::get('/admin/project', [AdminController::class, 'project']);
	Route::get('/admin/certificate/{id}/{st_id}', [AdminController::class, 'certificate']);


    Route::resource('/admin/dashboard-admin', HomeAdminController::class);
    Route::get('/admin/profile', [HomeAdminController::class, 'profile']);

    Route::resource('/member/dashboard-member', MemberController::class);
    Route::get('/member/course', [MemberController::class, 'course']);
    Route::get('/member/course/{p_id}', [MemberController::class, 'detailcourse']);
    Route::get('/member/dashboard-member', [MemberController::class, 'dashboard_member']);
    Route::get('/member/order', [MemberController::class, 'order']);
    Route::get('/member/membercard', [MemberController::class, 'membercard']);
    Route::get('/member/topup', [MemberController::class, 'topup']);
    Route::get('/member/finance', [MemberController::class, 'finance']);
    Route::get('/member/course/topic/{p_id}', [MemberController::class, 'topic']);
    Route::get('/member/course/topic/{p_id}/{st_id}', [MemberController::class, 'subtopic']);
    Route::get('/member/course/submission/{p_id}/{st_id}', [MemberController::class, 'submission']);
    Route::get('/member/course/test/{p_id}/{st_id}/{hasil_id}', [MemberController::class, 'test']);
    Route::get('/member/project', [MemberController::class, 'projectlist']);
    Route::get('/member/project/add', [MemberController::class, 'projectadd']);
    Route::get('/member/project/{project_id}', [MemberController::class, 'projectview']);
    Route::get('/member/project/phase/{phase_id}/{project_id}', [MemberController::class, 'activityview']);
    Route::get('/member/calendar', [MemberController::class, 'calendar']);
	Route::get('/member/certificate/{id}/{st_id}', [MemberController::class, 'certificate']);

    Route::get('/membercard/{group}/{memberid}/{position}/{expired}/{email}/{nohp}/{web}/{name}', [MemberCardController::class, 'membercard']);
	
	Route::get('/admin/question', [BankSoalController::class, 'question']);
	Route::get('/admin/question-choice/{id}', [BankSoalController::class, 'question_choice']);
	
	Route::get('/profiling', [HomeController::class, 'profiling']);
	Route::get('/profiling-edit', [HomeController::class, 'profilingEdit'])->name('profiling-edit');

    Route::get('/admin-group/{id}', [AdminController::class, 'group_courses']);
    Route::get('/admin-group/member/{id}', [AdminController::class, 'group_members']);
});
