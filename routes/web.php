<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

Route::view('/', 'employee');
Route::post('/get-employee', [Controller::class, 'get_employee']);
Route::post('/add-employee', [Controller::class, 'add_employee']);
Route::post('/edit-employee', [Controller::class, 'edit_employee']);
Route::post('/remove-employee', [Controller::class, 'remove_employee']);
Route::post('/remove-employee-photo', [Controller::class, 'remove_employee_photo']);

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return 'Cache cleared';
});
