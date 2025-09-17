
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Topic;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/topics/{subject_id}', function ($subject_id) {
    return Topic::where('subject_id', $subject_id)->get();
});
