<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/alarm', Index::class)->name('alarm.index');
    Route::any('/alarm/create', Create::class)->name('alarm.create');
    Route::any('/alarm/{id}', Update::class)->name('alarm.update');
    Route::any('/alarm/{id}/boolean/{column}', UpdateBoolean::class)->name('alarm.update.boolean');
});
