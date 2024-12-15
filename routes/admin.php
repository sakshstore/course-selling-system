<?php
 
 use App\Http\Controllers\Admin\BadgeController;
 use App\Http\Controllers\Admin\CampaignController;
 use App\Http\Controllers\Admin\ChatController;
 use App\Http\Controllers\Admin\ContactController;
 use App\Http\Controllers\Admin\CourseController;
 use App\Http\Controllers\Admin\DashboardMatric;
 use App\Http\Controllers\Admin\EventScoreController;
 use App\Http\Controllers\Admin\InvoiceController;
 use App\Http\Controllers\Admin\LeadController;
 use App\Http\Controllers\Admin\LeaderboardController;
 use App\Http\Controllers\Admin\LoginController;
 use App\Http\Controllers\Admin\LoginHistoryController;
 use App\Http\Controllers\Admin\NotificationController;
 use App\Http\Controllers\Admin\PlaylistController;
 use App\Http\Controllers\Admin\ProductController;
 use App\Http\Controllers\Admin\ProfileController;
 use App\Http\Controllers\Admin\SettingsController;
 use App\Http\Controllers\Admin\StudentController;
 use App\Http\Controllers\Admin\TagController;
 use App\Http\Controllers\Admin\TaskController;
 use App\Http\Controllers\Admin\TicketController;
 use App\Http\Controllers\Admin\UserController;
 use App\Http\Controllers\Admin\VideoController;
 use App\Http\Controllers\Admin\WithdrawalController;

 use App\Http\Controllers\ActivityLogController;

 
use Illuminate\Support\Facades\Route;



Route::prefix('v1/admin')->group(function () {
    // Course Routes
    Route::resource('courses', CourseController::class);
    Route::get('courses/{courseId}/playlists', [PlaylistController::class, 'index']);
    Route::post('courses/{courseId}/playlists', [PlaylistController::class, 'store']);
    Route::get('courses/{courseId}/playlists/{playlistId}/videos', [PlaylistController::class, 'getVideos']);
    Route::get('courses/{courseId}', [CourseController::class, 'show']);
    
    // Guest Routes
    Route::post('guest/send-otp', [LoginController::class, 'sendOtp']);
    Route::post('guest/verify-otp', [LoginController::class, 'verifyGuestOtp']);
    
    // Ticket Routes
    Route::resource('tickets', TicketController::class);
    Route::get('tickets_list', [TicketController::class, 'index']);
    Route::get('ticket-categories-priorities', [TicketController::class, 'getCategoriesAndPriorities']);
    Route::get('tickets/{ticketId}', [TicketController::class, 'show']);
    Route::get('tickets/{ticketId}/messages', [TicketController::class, 'getMessages']);
    Route::post('tickets/{ticketId}/messages', [TicketController::class, 'postMessage']);
    
    // Badge Routes
    Route::resource('badges', BadgeController::class);
    
    // Event Routes
    Route::resource('events', EventScoreController::class);
    
    // Settings Routes
    
Route::prefix('settings')->group(function () {
    Route::get('brand-settings', [SettingsController::class, 'getBrandSettings']);
    Route::post('brand-settings', [SettingsController::class, 'saveBrandSettings']);
    Route::get('api-key-settings', [SettingsController::class, 'getApikeySettings']);
    Route::post('api-key-settings', [SettingsController::class, 'saveApikeySettings']);
    Route::get('currency-symbol', [SettingsController::class, 'getCurrencySymbol']);
    Route::post('currency-symbol', [SettingsController::class, 'updateCurrencySymbol']);
    Route::get('SectionsText', [SettingsController::class, 'getSectionsText']);
    Route::post('SectionsText', [SettingsController::class, 'postSectionsText']);
    Route::post('saveloginBanner', [SettingsController::class, 'saveloginBanner']);
    Route::post('savecompanyLogo', [SettingsController::class, 'savecompanyLogo']);
    Route::get('smtp-settings', [SettingsController::class, 'getSMTP']);
    Route::post('smtp-settings', [SettingsController::class, 'saveSMTP']);
    Route::post('smtp-settings/test', [SettingsController::class, 'testSmtpSettings']);
    
});
    // Chat Routes
    Route::get('chats_list', [ChatController::class, 'index']);
    Route::post('chats', [ChatController::class, 'store']);
    
    // Contact Routes
    Route::get('getContactfields', [ContactController::class, 'getContactfields']);
    Route::post('getFilteredContacts', [ContactController::class, 'getFilteredContacts']);
    Route::resource('contacts', ContactController::class);
    Route::post('importContacts', [ContactController::class, 'importContacts']);
    
    // Tag Routes
    Route::resource('tags', TagController::class);
    
    // Campaign Routes
    Route::resource('campaigns', CampaignController::class);
    Route::post('campaigns/{campaignId}/duplicate', [CampaignController::class, 'duplicate']);
    
    // Product Routes
    Route::resource('products', ProductController::class);
    
    // Invoice Routes
    Route::resource('invoices', InvoiceController::class);
    Route::put('invoices/{id}/details', [InvoiceController::class, 'updateInvoiceDetails']);
    Route::put('invoices/{id}/dates-terms', [InvoiceController::class, 'updateInvoiceDatesAndTerms']);
    Route::put('invoices/{id}/note-terms', [InvoiceController::class, 'updateCustomerNoteAndTerms']);
    Route::put('invoices/{id}/products', [InvoiceController::class, 'updateProducts']);
    Route::post('invoices/{id}/file', [InvoiceController::class, 'updateFile']);
    
    // Dashboard Routes
    Route::get('dashboard-data', [DashboardMatric::class, 'getDashboardData']);
    Route::get('weekly-registered-users', [UserController::class, 'getWeeklyRegisteredUsers']);
    Route::get('activities', [ActivityLogController::class, 'index']);
    Route::get('new-students', [UserController::class, 'getNewStudents']);
    
    // Profile Routes
    Route::get('me', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    
    // Lead Routes
    Route::get('get_lead_status', [LeadController::class, 'get_lead_status']);
    Route::resource('leads', LeadController::class);
    Route::put('leads/updateStatus/{id}', [LeadController::class, 'updateStatus']);
    Route::post('leads/bulk_create', [LeadController::class, 'bulkCreate']);
    Route::delete('leads/delete_all', [LeadController::class, 'deleteAll']);
    Route::get('lead/dashboard_data', [LeadController::class, 'dashboardData']);
    Route::get('lead/report-by-tags', [LeadController::class, 'dashboardData']);
    
    // Video Routes
    Route::get('get_unattached_videos', [VideoController::class, 'get_unattached_videos']);
    Route::post('videos/upload-multiple', [VideoController::class, 'uploadMultipleVideos']);
    Route::get('get_attached_videos', [VideoController::class, 'get_attached_videos']);
    Route::get('videos/latest', [VideoController::class, 'getLastThreeVideos']);
    
    // Notification Routes
    Route::resource('notifications', NotificationController::class);
    
    // Leaderboard Routes
    Route::get('leaderboard/my-score', [LeaderboardController::class, 'myScore']);
    Route::get('leaderboard/my-score-history', [LeaderboardController::class, 'myScoreHistory']);
    
    // Login History Routes
    Route::resource('login-history', LoginHistoryController::class);
    
    // Task Routes
    Route::resource('tasks', TaskController::class);
    
    // Event Score Routes
    Route::resource('event-scores', EventScoreController::class);
    
    // Student Routes
    Route::resource('students', StudentController::class);
    Route::post('students/{student}/suspend', [StudentController::class, 'suspend']);
    Route::post('students/{student}/unsuspend', [StudentController::class, 'unsuspend']);
    Route::post('importstudents', [StudentController::class, 'importJson']);
    Route::get('students/{student}/purchase-history', [StudentController::class, 'purchaseHistory']);
    Route::get('students/{student}/login-history', [StudentController::class, 'loginHistory']);
    Route::get('students/{student}/invoices', [StudentController::class, 'invoices']);
    Route::post('students/{student}/increase-score', [LeaderboardController::class, 'increaseStudentScore']);
    Route::get('students/{student}/score-history', [LeaderboardController::class, 'fetchScoreHistory']);
    Route::get('students/{student}', [StudentController::class, 'show']);
    Route::get('students/{student}/badges', [StudentController::class, 'fetchBadges']);
    Route::get('students/{student}/activity-report', [StudentController::class, 'activityReport']);
    


    
    Route::get('students/{student}/courses', [StudentController::class, 'courses']);

    Route::post('/students/{student}/course/enroll', [StudentController::class, 'enroll']);

    Route::delete('/students/{student}/course/remove', [StudentController::class, 'removeFromCourse']);

    Route::get('students/{student}/badges', [StudentController::class, 'fetchBadges']);

    Route::post('students/{student}/increase-score', [LeaderboardController::class, 'increaseStudentScore']);
    Route::get('students/{student}/score-history', [LeaderboardController::class, 'fetchScoreHistory']);




    // Withdrawal Routes
    Route::post('request-withdrawal', [WithdrawalController::class, 'requestWithdrawal']);
    Route::resource('withdrawals', WithdrawalController::class);
    
    // User Routes
    Route::resource('users', UserController::class);
    Route::post('users/{id}/suspend', [UserController::class, 'suspend']);
    Route::post('users/{id}/unsuspend', [UserController::class, 'unsuspend']);
    Route::get('user/{id}/leads', [UserController::class, 'leads']);
    Route::get('user/{id}/contacts', [UserController::class, 'contacts']);











// LeadController
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



    // CampaignController
    Route::get('/campaigns_list', [CampaignController::class, 'index']);
    Route::post('/campaigns', [CampaignController::class, 'store']);
    Route::get('/campaign/{campaign}', [CampaignController::class, 'show']);
    Route::post('/campaigns/{campaign}/duplicate', [CampaignController::class, 'duplicate']);
    

    Route::get('getToken', [ProfileController::class, 'getToken']);


    });


