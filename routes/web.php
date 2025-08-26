<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Test route for debugging dropdowns
Route::get('/test-dropdowns', function () {
    return view('test-dropdowns');
})->name('test-dropdowns');

// Test API endpoints directly
Route::get('/test-api', function () {
    try {
        $province = \App\Models\Province::first();
        $district = \App\Models\District::first();
        $sector = \App\Models\Sector::first();
        $cell = \App\Models\Cell::first();
        
        return response()->json([
            'status' => 'success',
            'province' => $province,
            'district' => $district,
            'sector' => $sector,
            'cell' => $cell,
            'districts_for_province_1' => $province ? $province->districts()->get() : [],
            'sectors_for_district_1' => $district ? $district->sectors()->get() : [],
            'cells_for_sector_1' => $sector ? $sector->cells()->get() : [],
            'villages_for_cell_1' => $cell ? $cell->villages()->get() : [],
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Simple test route
Route::get('/test-simple', function () {
    return response()->json([
        'status' => 'working',
        'message' => 'API is accessible'
    ]);
});

// Database connection test
Route::get('/test-db', function () {
    try {
        $connection = \DB::connection();
        $connection->getPdo();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Database connected successfully',
            'database' => $connection->getDatabaseName()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Database connection failed',
            'error' => $e->getMessage()
        ], 500);
    }
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Settings routes
Route::middleware('auth')->group(function () {
    Route::get('/settings/profile', [SettingsController::class, 'profile'])->name('settings.profile');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::get('/settings/password', [SettingsController::class, 'changePassword'])->name('settings.change-password');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Worker availability toggle
    Route::post('/toggle-availability', [DashboardController::class, 'toggleAvailability'])->name('toggle-availability');
    
    // Job routes
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    
    // Boss-only routes (put these before the {job} route)
    Route::middleware('can:create,App\Models\Job')->group(function () {
        Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::get('/my-jobs', [JobController::class, 'myJobs'])->name('jobs.my-jobs');
        Route::get('/active-workers', [JobController::class, 'activeWorkers'])->name('jobs.active-workers');
        Route::delete('/jobs/{job}/workers/{jobOffer}', [JobController::class, 'removeWorker'])->name('jobs.remove-worker')->where('jobOffer', '[0-9]+');
        Route::patch('/jobs/{job}/end', [JobController::class, 'endJob'])->name('jobs.end-job');
    });
    
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
    
    // Boss-only job management routes
    Route::middleware('can:create,App\Models\Job')->group(function () {
        Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
    });

    // Job Offer routes
    Route::middleware('can:viewOffers,App\Models\JobOffer')->group(function () {
        Route::get('/job-offers', [JobOfferController::class, 'index'])->name('job-offers.index');
    });
    
    Route::post('/jobs/{job}/offer', [JobOfferController::class, 'store'])->name('job-offers.store');
    Route::delete('/job-offers/{jobOffer}', [JobOfferController::class, 'destroy'])->name('job-offers.destroy');

    // Boss job offer management routes
    Route::get('/jobs/{job}/offers', [JobOfferController::class, 'jobOffers'])->name('job-offers.job-offers');
    
    // Worker response routes
    Route::post('/job-offers/{jobOffer}/accept', [JobOfferController::class, 'accept'])->name('job-offers.accept');
    Route::post('/job-offers/{jobOffer}/decline', [JobOfferController::class, 'decline'])->name('job-offers.decline');

    // Application routes
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/jobs/{job}/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/jobs/{job}/applications', [ApplicationController::class, 'jobApplications'])->name('applications.job-applications');
    Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
    Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    
    // History routes
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{jobOffer}/feedback', [HistoryController::class, 'showFeedback'])->name('history.feedback');
    Route::post('/history/{jobOffer}/feedback', [HistoryController::class, 'storeFeedback'])->name('history.store-feedback');
    
    // API routes for available workers
    Route::get('/api/available-workers', [JobController::class, 'getAvailableWorkers'])->name('api.available-workers');
});

// API routes for administrative dropdowns (public access)
Route::get('/api/districts/{province}', [JobController::class, 'getDistricts'])->name('api.districts');
Route::get('/api/sectors/{district}', [JobController::class, 'getSectors'])->name('api.sectors');
Route::get('/api/cells/{sector}', [JobController::class, 'getCells'])->name('api.cells');
Route::get('/api/villages/{cell}', [JobController::class, 'getVillages'])->name('api.villages');
