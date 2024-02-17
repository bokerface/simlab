<?php

use Bokerface\Survey\SurveyController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('survey', [SurveyController::class, 'index']);
    Route::middleware(['middleware' => 'exclude_admin'])->group(function () {
        Route::post('survey', ['before' => 'csrf', SurveyController::class, 'submit_survey']);
    });
    Route::prefix('survey')->group(function () {
        Route::get('daftar-survey', [SurveyController::class, 'list']);
        Route::get('detail-jawaban-survey/{id_pertanyaan}', [SurveyController::class, 'text_survey']);
        Route::middleware(['middleware' => 'admin'])->group(function () {
            Route::get('tambah', [SurveyController::class, 'create']);
            Route::post('tambah', ['before' => 'csrf', SurveyController::class, 'store']);
            Route::get('edit/{id_survey}', [SurveyController::class, 'edit']);
            Route::get('edit/{id_survey}/tambah-pertanyaan', [SurveyController::class, 'tambah_pertanyaan']);
            Route::post('edit/{id_survey}/tambah-pertanyaan', [SurveyController::class, 'store_pertanyaan']);
            Route::post('update/{id_survey}', [SurveyController::class, 'update']);
            Route::get('edit-pertanyaan/{id_pertanyaan}', [SurveyController::class, 'edit_pertanyaan']);
            Route::put('edit-pertanyaan/{id_pertanyaan}', ['before' => 'csrf', SurveyController::class, 'update_pertanyaan']);
            Route::delete('hapus-pertanyaan/{id_pertanyaan}', ['before' => 'csrf', SurveyController::class, 'destroy_pertanyaan']);
        });
    });
});
