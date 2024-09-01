<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Employee\EmployeeViewController;


Route::group(['middleware' => 'auth:employee'], function () {
    Route::name('employee.')->prefix('employee')->group(function() {
        Route::get('/', [EmployeeViewController::class, 'index'])->name("index");
        Route::post('/specialization/add', [EmployeeViewController::class, 'addSpecialization'])->name("specialization.add");
        Route::get('/specialization/setstate/{id}/{state}/', [EmployeeViewController::class, 'setSpecializationState'])->name("specialization.setstate");
        Route::post('/role/add', [EmployeeViewController::class, 'addRole'])->name("role.add");
        
    });
});


/*
route("employee.index") -> 127.0.0.1:8000/employee/
route("employee.addspecialization") -> 127.0.0.1:8000/employee/addspecialization
*/