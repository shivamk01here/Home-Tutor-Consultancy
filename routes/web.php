<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TutorController;
use App\Models\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationChoiceForm'])->name('register.choice');
Route::get('/register/student', [AuthController::class, 'showStudentRegistrationForm'])->name('register.student');
Route::post('/register/student', [AuthController::class, 'registerStudent']);
Route::get('/register/tutor', [AuthController::class, 'showTutorRegistrationForm'])->name('register.tutor');
Route::post('/register/tutor', [AuthController::class, 'registerTutor']);

// Protected Dashboards & Features
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Tutor Management
    Route::get('/tutors', [AdminController::class, 'showTutors'])->name('tutors.index');
    Route::get('/tutors/create', [AdminController::class, 'showTutorCreateForm'])->name('tutors.create');
    Route::post('/tutors/create', [AdminController::class, 'createTutor']);
    Route::get('/tutors/{tutor}', [AdminController::class, 'showTutorDetails'])->name('tutors.show');
    Route::post('/tutors/{tutor}/verify', [AdminController::class, 'verifyTutor'])->name('tutor.verify');
    Route::delete('/tutors/{tutor}', [AdminController::class, 'deleteTutor'])->name('tutor.delete');

    // Student Management
    Route::get('/students', [AdminController::class, 'showStudents'])->name('students.index');
    Route::get('/students/create', [AdminController::class, 'showStudentCreateForm'])->name('students.create');
    Route::post('/students/create', [AdminController::class, 'createStudent']);
    Route::get('/students/{student}', [AdminController::class, 'showStudentDetails'])->name('students.show');

    // Subject Management
    Route::get('/subjects', [AdminController::class, 'showSubjectManagement'])->name('subjects.index');
    Route::post('/subjects/create', [AdminController::class, 'createSubject'])->name('subjects.create');


    Route::get('/topics', [AdminController::class, 'showTopics'])->name('topics.index');
    Route::post('/topics', [AdminController::class, 'createTopic'])->name('topics.create');

    // Mock Test Management
    Route::get('/mock-tests', [AdminController::class, 'showMockTests'])->name('mock-tests.index');
    Route::get('/mock-tests/create', [AdminController::class, 'showMockTestCreateForm'])->name('mock-tests.create');
    Route::post('/mock-tests', [AdminController::class, 'createMockTest'])->name('mock-tests.store');

    // Payment Management
    Route::get('/payments', [AdminController::class, 'showPayments'])->name('payments');
    Route::post('/payments/{session}/mark-as-paid', [AdminController::class, 'markPayment'])->name('payments.mark');

    Route::get('/feedback', [AdminController::class, 'showFeedback'])->name('feedback.index');
    Route::get('/sessions', [AdminController::class, 'showSessions'])->name('sessions.index');
});

Route::get('/topics/{subject_id}', function ($subject_id) {
    return App\Models\Topic::where('subject_id', $subject_id)->get();
});

Route::middleware(['auth', 'role:tutor', 'is.verified'])->prefix('tutor')->name('tutor.')->group(function () {
    Route::get('/dashboard', [TutorController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [TutorController::class, 'showProfileForm'])->name('profile.show');
    Route::post('/profile', [TutorController::class, 'updateProfile'])->name('profile.update');
    Route::get('/session/{session}/manage', [TutorController::class, 'showSessionManagement'])->name('session.manage');
    Route::post('/session/{session}/complete', [TutorController::class, 'completeSession'])->name('session.complete');
    Route::get('/resources', [TutorController::class, 'showHybridLearning'])->name('resources');
    Route::post('/resources/upload', [TutorController::class, 'uploadResource'])->name('resources.upload');
    Route::get('/feedback', [TutorController::class, 'showFeedbackForm'])->name('feedback.create');
    Route::post('/feedback', [TutorController::class, 'submitFeedback'])->name('feedback.submit');
    Route::get('/packages', [TutorController::class, 'showPackageManagement'])->name('packages.index');
    Route::post('/packages', [TutorController::class, 'createPackage'])->name('packages.create');
    Route::get('/sessions', [TutorController::class, 'showSessions'])->name('sessions.index');
    Route::post('/sessions/{session}/complete', [TutorController::class, 'completeSession'])->name('session.complete');
    Route::get('/earnings', [TutorController::class, 'showEarnings'])->name('earnings.index');


});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/find-tutor', [StudentController::class, 'showTutorDiscovery'])->name('discovery');
    Route::get('/tutor/{tutor}', [StudentController::class, 'showTutorProfile'])->name('tutor.profile');
    Route::post('/book-session', [StudentController::class, 'bookSession'])->name('book.session');
    Route::get('/review/{session}', [StudentController::class, 'showReviewForm'])->name('review.show');
    Route::post('/review/{session}/submit', [StudentController::class, 'submitReview'])->name('review.submit');
    Route::get('/mock-tests', [StudentController::class, 'showMockTests'])->name('mock-tests.index');

    Route::get('/mock-tests/{mockTest}/give', [StudentController::class, 'giveMockTest'])->name('mock-tests.give');
    Route::post('/mock-tests/{mockTest}/submit', [StudentController::class, 'submitMockTest'])->name('mock-tests.submit');
    Route::get('/mock-tests/results/{result}', [StudentController::class, 'showMockTestResults'])->name('mock-tests.results');
    Route::get('/progress', [StudentController::class, 'showStudentProgress'])->name('progress.index');
    Route::get('/feedback', [StudentController::class, 'showFeedbackForm'])->name('feedback.create');
    Route::post('/feedback', [StudentController::class, 'submitFeedback'])->name('feedback.submit');

     Route::post('/book-session', [StudentController::class, 'bookSession'])->name('book.session');
    Route::get('/sessions', [StudentController::class, 'showMySessions'])->name('sessions.index');

});