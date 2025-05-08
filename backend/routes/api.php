<?php

use App\Http\Controllers\Api\V1\Admin\TaskController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Auth route start*/
Route::group(['prefix' => 'v1/auth', 'middleware' => 'throttle:api'], function(){

    /*login route start*/
    Route::post('login', [LoginController::class, 'login']);
    /*login route end*/

    /*logout and check token route start*/
    Route::group(['middleware' => ['jwtAuth', 'throttle:api']], function() {

        /*lgout api route start*/
        Route::post('logout', [LoginController::class, 'logout']);
        /*lgout api route end*/

        /*check token route start*/
        Route::post('checkTokne', [LoginController::class, 'checkToken']);
        /*check token route end*/
    });
    /*logout and check token route end*/
});
/*Auth route end*/

/*Web admin route start*/
Route::group(['prefix' => 'v1/admin', 'middleware' => ['jwtAuth', 'throttle:api']], function() {

    /*Task route start*/
    Route::get('task', [TaskController::class, 'index']);
    Route::post('task', [TaskController::class, 'store'])->name('admin.store.task');
    Route::get('task/{id}', [TaskController::class, 'show']);
    Route::put('task/{id}', [TaskController::class, 'update'])->name('admin.update.task');
    Route::delete('task/{id}', [TaskController::class, 'destroy']);
    Route::patch('task/changeStatus/{id}', [TaskController::class, 'changeStatus'])->name('admin.changeStatus.task');
    Route::patch('task/changeCompleteStatus/{id}', [TaskController::class, 'changeCompleteStatus'])->name('admin.changeCompleteStatus.task');
    /*Task route end*/

});
/*Web admin route end*/