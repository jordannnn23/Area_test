<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\YoutubeController;


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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('send-mail', [SubscriberController::class, 'index']);
Route::get('/send',[MailController::class, 'index']);

// Route::get('send-mail', [SubscriberController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('accueil-youtube', [YoutubeController::class, 'index']);
Route::get('accueil-youtube/callback', [YoutubeController::class, 'getCode']);
Route::get('youtube/callback', [YoutubeController::class, 'get_notification']);


require __DIR__.'/auth.php';
