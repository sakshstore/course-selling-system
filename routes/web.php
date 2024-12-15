<?php


use App\Http\Controllers\LoginController;
use App\Http\Controllers\SystemController;
/*
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminTicketController;


use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardMatric;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EventScoreController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\LoginHistoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudyMaterialController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WithdrawalController;

*/
use Illuminate\Support\Facades\Route;
Route::middleware('auth')->group(function () {
include "admin.php";

include "guest.php";
});

Route::prefix('v1')->group(function () {


Route::prefix('auth')->group(function () {
    Route::post('send-otp', [LoginController::class, 'sendAuthOtp']);
    Route::post('verify-otp', [LoginController::class, 'verifyAuthOtp']);
    });



    Route::prefix('guide')->group(function () {
    Route::post('send-otp', [LoginController::class, 'sendAuthOtp']);
    Route::post('verify-otp', [LoginController::class, 'verifyGuideOTP']);
    });


    Route::prefix('admin')->group(function () {
    Route::post('send-otp', [LoginController::class, 'sendAdminOTP']);
    Route::post('verify-otp', [LoginController::class, 'verifyAdminOTP']);
    });

});



Route::any('logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('v1')->group(function () {

    Route::get('settings/currency-symbol', [SystemController::class, 'getCurrencySymbol']);

    Route::get('settings/brand-settings', [SystemController::class, 'getBrandSettings']);

    Route::get('settings/SectionsText', [SystemController::class, 'getSectionsText']);



});
/*
 
Route::prefix('v1/guest')->group(function () {





    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

    Route::get('/videos/latest', [VideoController::class, 'getLastThreeVideos']);
    // Authentication Routes
    Route::post('login', [LoginController::class, 'login'])->name('login3');
  

    


    Route::get('setup', [LoginController::class, 'test'])->name('setup');

});




Route::any('logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('v1')->group(function () {

    Route::get('settings/currency-symbol', [SystemController::class, 'getCurrencySymbol']);

    Route::get('settings/brand-settings', [SystemController::class, 'getBrandSettings']);

    Route::get('settings/SectionsText', [SystemController::class, 'getSectionsText']);

    Route::get('', [LoginController::class, 'showLoginFor'])->name('login2');
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

    Route::get('/videos/latest', [VideoController::class, 'getLastThreeVideos']);
    // Authentication Routes
    Route::post('login', [LoginController::class, 'login'])->name('login3');




    Route::post('register', [RegisterController::class, 'register']);

    // Public Product Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    // Authenticated Routes
    Route::middleware('auth')->group(function () {

        Route::get('login-history', [LoginHistoryController::class, 'index']);

        Route::get('courses/enrollments', [CourseController::class, 'getEnrollments']);

        Route::get('/events', [ActivityLogController::class, 'events']);

        Route::get('/badges', [BadgeController::class, 'index']);

        Route::delete('/badges/{badge}', [BadgeController::class, 'destroy']);

        Route::post('/badges', [BadgeController::class, 'store']);
        Route::post('/award-badge', [BadgeController::class, 'awardBadge']);

        Route::get('/leaderboard/my-score', [LeaderboardController::class, 'myScore']);
        Route::get('/leaderboard/my-score-history', [LeaderboardController::class, 'myScoreHistory']);

        Route::get('/leaderboard', [LeaderboardController::class, 'index']);
        Route::post('/update-score', [LeaderboardController::class, 'updateScore']);

        Route::post('/leaderboard/increase-score', [LeaderboardController::class, 'increaseScore']);

        Route::post('/request-withdrawal', [WithdrawalController::class, 'requestWithdrawal'])->name('request.withdrawal');
        Route::get('/admin/withdrawals', [WithdrawalController::class, 'adminIndex'])->name('admin.withdrawals');
        Route::post('/admin/withdrawals/{id}/approve', [WithdrawalController::class, 'approveWithdrawal'])->name('admin.withdrawals.approve');

        Route::get('referral-report', [UserController::class, 'referralReport'])->name('user.referral.report');

        Route::post('generate-referral-code', [UserController::class, 'generateReferralCode'])->name('generate.referral.code');

        Route::get('withdrawals', [WithdrawalController::class, 'fetchWithdrawals'])->name('fetch.withdrawals');

        Route::get('transactions', [TransactionController::class, 'fetchTransactions'])->name('fetch.transactions');

        Route::get('settings/currency-symbol', [SystemController::class, 'getCurrencySymbol']);

        Route::post('settings/currency-symbol', [SystemController::class, 'updateCurrencySymbol']);

        Route::get('settings/SectionsText', [SystemController::class, 'getSectionsText']);

        Route::post('settings/SectionsText', [SystemController::class, 'postSectionsText']);

        Route::post('settings', [SystemController::class, 'updateSettings']);

        Route::get('/smtp-settings', [SystemController::class, 'getSMTP']);
        Route::post('/smtp-settings', [SystemController::class, 'saveSMTP']);
        Route::post('/smtp-settings/test', [SystemController::class, 'testSmtpSettings']);

        Route::post('settings/saveloginBanner', [SystemController::class, 'saveloginBanner']);

        Route::post('settings/savecompanyLogo', [SystemController::class, 'savecompanyLogo']);

        Route::get('settings/api-key-settings', [SystemController::class, 'getApikeySettings']);
        Route::post('settings/api-key-settings', [SystemController::class, 'saveApikeySettings']);

        Route::get('/brand-settings', [SystemController::class, 'getBrandSettings']);
        Route::post('/brand-settings', [SystemController::class, 'saveBrandSettings']);

        Route::get('event-scores', [EventScoreController::class, 'index']);
        Route::post('event-scores', [EventScoreController::class, 'store']);
        Route::get('event-scores/{id}', [EventScoreController::class, 'show']);
        Route::put('event-scores/{id}', [EventScoreController::class, 'update']);
        Route::delete('event-scores/{id}', [EventScoreController::class, 'destroy']);

        Route::get('activities', [ActivityLogController::class, 'index']);
        Route::get('notifications', [NotificationController::class, 'index']);
        Route::get('me', [ProfileController::class, 'show']);

        Route::get('getToken', [ProfileController::class, 'getToken']);

        Route::get('weekly-registered-users', [UserController::class, 'getWeeklyRegisteredUsers']);

        Route::get('active-users', [UserController::class, 'getActiveUsers']);

        Route::get('recent-registrations', [UserController::class, 'getRecentRegistrations']);
        Route::get('total-sales', [InvoiceController::class, 'getTotalSales']);
        Route::get('monthly-sales', [InvoiceController::class, 'getMonthlySales']);
        Route::get('top-selling-course', [InvoiceController::class, 'getTopSellingCourse']);
        Route::get('total-refunds-and-cancellations', [InvoiceController::class, 'getTotalRefundsAndCancellations']);
        Route::get('dashboard-data', [DashboardMatric::class, 'getDashboardData']);
        Route::get('new-students', [UserController::class, 'getNewStudents']);

        //Route::get('/students', [UserController::class, 'index']);

        Route::get('students', [StudentController::class, 'index']);
        Route::post('students', [StudentController::class, 'store']);
        Route::get('students/{id}', [StudentController::class, 'show']);
        Route::put('students/{id}', [StudentController::class, 'update']);
        Route::delete('students/{id}', [StudentController::class, 'destroy']);
        Route::post('students/{id}/suspend', [StudentController::class, 'suspend']);
        Route::post('students/{id}/unsuspend', [StudentController::class, 'unsuspend']);
        Route::post('/students/import', [StudentController::class, 'import']);

        Route::get('students/{id}/login-history', [StudentController::class, 'loginHistory']);
        Route::get('students/{id}/activity-report', [StudentController::class, 'activityReport']);
        Route::get('students/{id}/purchase-history', [StudentController::class, 'purchaseHistory']);

        Route::post('importstudents', [StudentController::class, 'importJson']);

        Route::post('getFilteredStudents', [StudentController::class, 'getFilteredStudents']);

        Route::get('getStudentImportfields', [StudentController::class, 'getStudentImportfields']);

        Route::get('students/{student}/courses', [StudentController::class, 'courses']);

        Route::post('/students/{student}/course/enroll', [StudentController::class, 'enroll']);

        Route::delete('/students/{student}/course/remove', [StudentController::class, 'removeFromCourse']);

        Route::get('students/{student}/badges', [StudentController::class, 'fetchBadges']);

        Route::post('students/{student}/increase-score', [LeaderboardController::class, 'increaseStudentScore']);
        Route::get('students/{student}/score-history', [LeaderboardController::class, 'fetchScoreHistory']);

        // Contact Routes
        Route::get('/contacts_list', [ContactController::class, 'index']);
        Route::post('/contacts', [ContactController::class, 'store']);
        Route::put('/contacts/{contact}', [ContactController::class, 'update']);
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);
        Route::post('/contacts/import', [ContactController::class, 'import'])->name('contacts.import');
        Route::get('/contacts/export', [ContactController::class, 'export'])->name('contacts.export');

        Route::post('importContacts', [ContactController::class, 'importContacts']);

        Route::post('getFilteredContacts', [ContactController::class, 'getFilteredContacts']);

        Route::get('getContactfields', [ContactController::class, 'getContactfields']);


















        // Ticket Routes

        Route::resource('tickets', TicketController::class);
        Route::get('/tickets_list', [TicketController::class, 'index']);
        Route::get('/ticket-categories-priorities', [TicketController::class, 'getCategoriesAndPriorities']);

        // Message Routes
        Route::get('/tickets/{ticketId}/messages', [TicketController::class, 'getMessages']);
        
        Route::post('/tickets/{ticketId}/messages', [TicketController::class, 'postMessage']);

        Route::prefix('admin')->group(function () {
            Route::resource('tickets', AdminTicketController::class);
            Route::get('/tickets_list', [AdminTicketController::class, 'index']);
            Route::get('/ticket-categories-priorities', [TicketController::class, 'getCategoriesAndPriorities']);

            // Message Routes
            Route::get('/tickets/{ticketId}/messages', [AdminTicketController::class, 'getMessages']);
            Route::post('/tickets/{ticketId}/messages', [AdminTicketController::class, 'postMessage']);

        });













        // Chat Routes
        Route::get('/chats_list', [ChatController::class, 'index']);
        Route::post('/chats', [ChatController::class, 'store']);

        // Campaign Routes
        Route::get('/campaigns_list', [CampaignController::class, 'index']);
        Route::post('/campaigns', [CampaignController::class, 'store']);
        Route::get('/campaign/{campaign}', [CampaignController::class, 'show']);
        Route::post('/campaigns/{campaign}/duplicate', [CampaignController::class, 'duplicate']);
        
        Route::get('/tags', [TagController::class, 'index']);

        // Task Routes
        Route::resource('tasks', TaskController::class)->except(['create', 'edit']);

        // Document Routes
        Route::resource('documents', DocumentController::class)->except(['create', 'edit']);

        // Product Routes
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

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

        // Profile Routes
        Route::get('/me', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);

        // Invoice Routes
        Route::get('/invoices', [InvoiceController::class, 'index']);
        Route::post('/invoices', [InvoiceController::class, 'store']);
        Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
        Route::post('/invoices/{id}', [InvoiceController::class, 'update']);
        Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy']);
        Route::get('/invoices/{id}/download', [InvoiceController::class, 'downloadPDF']);
        Route::put('/invoices/{id}/details', [InvoiceController::class, 'updateInvoiceDetails']);
        Route::put('/invoices/{id}/dates-terms', [InvoiceController::class, 'updateInvoiceDatesAndTerms']);
        Route::put('/invoices/{id}/note-terms', [InvoiceController::class, 'updateCustomerNoteAndTerms']);
        Route::put('/invoices/{id}/products', [InvoiceController::class, 'updateProducts']);
        Route::post('/invoices/{id}/file', [InvoiceController::class, 'updateFile']);



        Route::prefix('admin')->group(function () {


        // Course and Study Material Routes
        Route::resource('courses', CourseController::class);

        Route::prefix('courses/{course}/study-materials')->group(function () {
            Route::get('/', [StudyMaterialController::class, 'index']);
            Route::post('/', [StudyMaterialController::class, 'store']);
            Route::get('{id}', [StudyMaterialController::class, 'show']);
            Route::put('{id}', [StudyMaterialController::class, 'update']);
            Route::delete('{id}', [StudyMaterialController::class, 'destroy']);
        });

        // Playlist and Video Routes
        Route::get('/courses/{courseId}/playlists', [PlaylistController::class, 'index']);
        Route::post('/courses/{courseId}/playlists', [PlaylistController::class, 'store']);
        Route::post('/playlists/{playlistId}/study-materials', [PlaylistController::class, 'addStudyMaterial']);

        Route::get('/courses/{courseId}/videos', [VideoController::class, 'getVideosByCourse']);
        Route::get('/courses/{courseId}/videos', [VideoController::class, 'getVideosByCourse']);

        Route::get('courses/enrollments', [CourseController::class, 'getEnrollments']);

        Route::get('courses/{courseId}/playlists/{playlistId}/videos', [PlaylistController::class, 'getVideos']);
        Route::post('videos', [VideoController::class, 'store']);
        Route::get('video/{video}', [VideoController::class, 'get_video']);
        Route::post('video/{video}', [VideoController::class, 'post_video']);
        Route::get('get_videos', [VideoController::class, 'get_videos']);
        Route::get('get_unattached_videos', [VideoController::class, 'get_unattached_videos']);
        Route::get('get_attached_videos', [VideoController::class, 'get_attached_videos']);

        Route::get('my-courses', [CourseController::class, 'getUserCourses']);

        Route::post('videos/upload-multiple', [VideoController::class, 'uploadMultipleVideos']);

        Route::get('recommended-courses', [CourseController::class, 'getRecommendedCourses']);

        Route::get('recently-viewed-courses', [CourseController::class, 'getRecommendedCourses']);


    });





        // Admin Routes
        Route::group(['middleware' => ['role:admin']], function () {
            Route::get('/users_list', [UserController::class, 'index']);
            Route::post('/users/{user}/suspend', [UserController::class, 'suspend']);
            Route::post('/users/{user}/unsuspend', [UserController::class, 'unsuspend']);
            Route::put('/users/{user}', [UserController::class, 'update']);
            Route::get('/user/{user}/contacts', [UserController::class, 'contacts']);
            Route::get('/user/{user}/leads', [UserController::class, 'leads']);
            Route::delete('/users/{user}', [UserController::class, 'destroy']);
        });

    });
});

*/

if (!request()->is('v1/*')) {

    Route::get('/{any}', function () {
        return view('welcome');
    })->where('any', '.*');

}

Route::get('/v1/home', function () {
    return view('landingpage_1');
});

Route::get('/v1/home2', function () {
    return view('landingpage_2');
});

Route::get('/v1/test', [LoginController::class, 'test'])->name('test'); 