<?php

use App\Http\Controllers\Auth\ActivityLogController;
use App\Http\Controllers\Auth\BadgeController;
use App\Http\Controllers\Auth\CourseController;
use App\Http\Controllers\Auth\LeaderboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginHistoryController;
use App\Http\Controllers\Auth\NotificationController;
use App\Http\Controllers\Auth\PlaylistController;
use App\Http\Controllers\Auth\ProductController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SettingsController;
use App\Http\Controllers\Auth\TicketController;
use App\Http\Controllers\Auth\TransactionController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VideoController;
use App\Http\Controllers\Auth\WithdrawalController;


use Illuminate\Support\Facades\Route;



Route::any('logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('v1')->group(function () {
// Settings Routes
 
// Login Routes
Route::get('', [LoginController::class, 'showLoginFor'])->name('login2');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login3');
Route::post('send-otp', [LoginController::class, 'sendOtp']);
Route::post('verify-otp', [LoginController::class, 'verifyOtp']);
Route::post('admin-send-otp', [LoginController::class, 'adminsendOtp']);
Route::post('admin-verify-otp', [LoginController::class, 'adminverifyOtp']);
Route::post('register', [RegisterController::class, 'register']);

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Video Routes
Route::get('/videos/latest', [VideoController::class, 'getLastThreeVideos']);

// Authenticated Routes
Route::middleware('auth')->group(function () {
// Login History Routes
Route::get('login-history', [LoginHistoryController::class, 'index']);

// Course Routes
Route::get('courses/enrollments', [CourseController::class, 'getEnrollments']);
Route::get('my-courses', [CourseController::class, 'getUserCourses']);

Route::get('courses', [CourseController::class, 'getUserCourses']);

Route::get('courses/{course}', [CourseController::class, 'show']);
Route::get('courses/{course}/playlists/videos', [PlaylistController::class, 'getPlaylistVideos']);


Route::get('recommended-courses', [CourseController::class, 'getRecommendedCourses']);
Route::get('recently-viewed-courses', [CourseController::class, 'getRecommendedCourses']);

// Event Routes
Route::get('/events', [ActivityLogController::class, 'events']);
Route::get('activities', [ActivityLogController::class, 'index']);

// Badge Routes
Route::get('/badges', [BadgeController::class, 'index']);
Route::delete('/badges/{badge}', [BadgeController::class, 'destroy']);
Route::post('/badges', [BadgeController::class, 'store']);
Route::post('/award-badge', [BadgeController::class, 'awardBadge']);

// Leaderboard Routes
Route::get('/leaderboard/my-score', [LeaderboardController::class, 'myScore']);
Route::get('/leaderboard/my-score-history', [LeaderboardController::class, 'myScoreHistory']);
Route::get('/leaderboard', [LeaderboardController::class, 'index']);
Route::post('/update-score', [LeaderboardController::class, 'updateScore']);
Route::post('/leaderboard/increase-score', [LeaderboardController::class, 'increaseScore']);
Route::post('students/{student}/increase-score', [LeaderboardController::class, 'increaseStudentScore']);
Route::get('students/{student}/score-history', [LeaderboardController::class, 'fetchScoreHistory']);

// Withdrawal Routes
Route::post('/request-withdrawal', [WithdrawalController::class, 'requestWithdrawal'])->name('request.withdrawal');
Route::get('withdrawals', [WithdrawalController::class, 'fetchWithdrawals'])->name('fetch.withdrawals');

// Transaction Routes
Route::get('transactions', [TransactionController::class, 'fetchTransactions'])->name('fetch.transactions');

// Referral Routes
Route::get('referral-report', [UserController::class, 'referralReport'])->name('user.referral.report');
Route::post('generate-referral-code', [UserController::class, 'generateReferralCode'])->name('generate.referral.code');

// Notification Routes
Route::get('notifications', [NotificationController::class, 'index']);

// Profile Routes
Route::get('me', [ProfileController::class, 'show']);
Route::put('/profile', [ProfileController::class, 'update']);

// Ticket Routes
Route::resource('tickets', TicketController::class);
Route::get('/tickets_list', [TicketController::class, 'index']);
Route::get('/ticket-categories-priorities', [TicketController::class, 'getCategoriesAndPriorities']);
Route::get('/tickets/{ticketId}/messages', [TicketController::class, 'getMessages']);
Route::post('/tickets/{ticketId}/messages', [TicketController::class, 'postMessage']);

// Tag Routes
Route::get('/tags', [TagController::class, 'index']);

// Lead Routes
Route::get('/leads_list', [LeadController::class, 'index']);
Route::get('/get_lead_status', [LeadController::class, 'get_lead_status']);
Route::get('/leads/{lead}', [LeadController::class, 'getlead']);
Route::post('/leads', [LeadController::class, 'store']);
Route::put('/leads/{lead}', [LeadController::class, 'update']);
Route::delete('/leads/delete_all', [LeadController::class, 'deleteAll']);
Route::put('/leads/updateStatus/{lead}', [LeadController::class, 'updateStatus']);
Route::delete('/leads/{lead}', [LeadController::class, 'destroy']);
Route::post('/leads/bulk_create', [LeadController::class, 'bulkCreate']);
Route::get('/lead/report-by-tags', [LeadController::class, 'dashboardData']);
Route::get('/lead/dashboard_data', [LeadController::class, 'dashboardData']);

// Playlist and Video Routes
Route::get('/courses/{courseId}/playlists', [PlaylistController::class, 'index']);
Route::post('/courses/{courseId}/playlists', [PlaylistController::class, 'store']);
Route::post('/playlists/{playlistId}/study-materials', [PlaylistController::class, 'addStudyMaterial']);
Route::get('/courses/{courseId}/videos', [VideoController::class, 'getVideosByCourse']);
Route::get('courses/{courseId}/playlists/{playlistId}/videos', [PlaylistController::class, 'getVideos']);


//Route::post('videos', [VideoController::class, 'store']);
Route::get('video/{video}', [VideoController::class, 'get_video']);
//Route::post('video/{video}', [VideoController::class, 'post_video']);
Route::get('get_videos', [VideoController::class, 'get_videos']);
//Route::get('get_unattached_videos', [VideoController::class, 'get_unattached_videos']);
//Route::get('get_attached_videos', [VideoController::class, 'get_attached_videos']);
//Route::post('videos/upload-multiple', [VideoController::class, 'uploadMultipleVideos']);
});
});