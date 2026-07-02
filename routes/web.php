<?php

use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AttendanceController; // 👈 1. Attendance Controller ko yahan import kiya
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MentorController;



// 🔒 FIXES 404 ERROR: Jab view profile par click hoga toh yeh chalega
Route::get('/mentor/profile/{id}', [MentorController::class, 'showInternProfile'])->name('mentor.profile');

// 🔄 SUBMIT REVIEW: Jab mentor approve/reject ka button dabayega
Route::post('/mentor/review/{id}', [MentorController::class, 'reviewTask'])->name('mentor.review-task');

// 🔒 1. INTERN ROLE CHECK MIDDLEWARE
class CheckInternMiddleware
{
    public function handle($request, $next)
    {
        if (auth()->check() && auth()->user()->role !== 'intern') {
            return redirect()->route('mentor.dashboard')->with('error', 'You cannot access the Intern panel.');
        }
        return $next($request);
    }
}

// 🔒 2. MENTOR ROLE CHECK MIDDLEWARE
class CheckMentorMiddleware
{
    public function handle($request, $next)
    {
        if (auth()->check() && auth()->user()->role !== 'mentor') {
            return redirect()->route('tasks.index')->with('error', 'Unauthorized! You cannot access the Mentor panel.');
        }
        return $next($request);
    }
}


// ==========================================
// 🔓 PUBLIC ROUTES (No Auth Required)
// ==========================================

Route::get('/login', [CustomAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [CustomAuthController::class, 'login'])->name('custom.login');
Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');


// ==========================================
// 🛡️ PROTECTED ROUTES (Auth Required)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // ==========================================
    // 🧑‍💻 INTERN PANEL (Protected from Mentors)
    // ==========================================
    Route::prefix('intern')->middleware([CheckInternMiddleware::class])->group(function () {
        
        Route::get('/dashboard', function () { return view('intern.dashboard'); })->name('intern.dashboard');
        
        // 🟢 INTERN ATTENDANCE ROUTE (Ab Controller ke zariye data bhejega)
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance/checkin', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
        Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout'); // 👈 YEH LINE ADD KAREIN
        // Tasks Management Routes
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::post('/tasks/{id}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
        Route::post('/tasks/{id}/submit-link', [TaskController::class, 'submitLink'])->name('tasks.submitLink');
        Route::post('/task/submit', [TaskController::class, 'storeSubmission'])->name('task.submit');

        Route::get('/chat', function () { return view('intern.chat'); })->name('intern.chat');
         
        // 🟢 UPDATED CERTIFICATE ROUTES FOR INTERN
       // 🟢 DYNAMIC CERTIFICATE ROUTES FOR INTERN (Inhe purane static route se replace krden)
    Route::get('/certificate', [CertificateController::class, 'showCertificate'])->name('intern.certificate');
    Route::post('/certificate/generate/{id}', [CertificateController::class, 'generateCertificate'])->name('certificates.generate');

    });

    // ==========================================
    // 👨‍🏫 MENTOR PANEL (Protected from Interns)
    // ==========================================
    Route::prefix('mentor')->middleware([CheckMentorMiddleware::class])->group(function () {
        
        Route::get('/dashboard', function () { return view('mentor.dashboard'); })->name('mentor.dashboard');
        
        // 🟢 MENTOR ATTENDANCE ROUTE (Sir Talha ke dekhne ke liye)
        Route::get('/attendances', [AttendanceController::class, 'mentorIndex'])->name('mentor.attendances');
        
        Route::get('/interns', function () {
            // User table se sirf un users ko uthana jinki role 'intern' hai
            $registeredInterns = \App\Models\User::where('role', 'intern')->get();
            
            // Data ko interns directory ki blade file mein pass karna
            return view('mentor.interns', compact('registeredInterns'));
        })->name('mentor.interns');
        Route::get('/mentor/profile/{id}', function ($id) {
            // Intern database profile load logic
            $intern = \App\Models\User::findOrFail($id);
            
            // Submissions bifurcation logic
            $pendingSubmissions = \App\Models\WeeklySubmission::where('user_id', $id)->where('status', 'pending')->get();
            $approvedSubmissions = \App\Models\WeeklySubmission::where('user_id', $id)->where('status', 'approved')->get();
            
            return view('mentor.profile', compact('intern', 'pendingSubmissions', 'approvedSubmissions'));
        })->name('mentor.profile');
        Route::get('/chat', function () { return view('mentor.chat'); })->name('mentor.chat');
        
    });

    // Profile Routes (Updated to use ProfileController)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // ==========================================
    // 🔄 SHARED ACTIONS (Chat, Certificates & Profile)
    // ==========================================
    
        // Is URL ko jab aap browser me open karengi (/mentor/certificates), to error nahi aayega
    Route::get('/mentor/certificate', [CertificateController::class, 'index']);

    // AJAX action route
    Route::post('/mentor/unlock-certificate/{intern_id}', [CertificateController::class, 'unlock']);
    Route::post('/send-message', [ChatController::class, 'store']);
    Route::get('/get-messages/{channel}', [ChatController::class, 'fetchMessages']);

    Route::get('/profile/edit', function () { 
        return view('profile.edit'); 
    })->name('profile.edit');
});