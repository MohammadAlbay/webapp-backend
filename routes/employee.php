<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\EmployeeViewController;
use App\Http\Controllers\Employee\EmployeeRoleController;
use App\Http\Controllers\Employee\EmployeePermissionController;
use App\Http\Controllers\Employee\PrepaidCardController;
use App\Http\Controllers\Employee\EmployeeViewResourceLoader;


Route::group(['middleware' => 'auth:employee'], function () {
    Route::name('employee.')->prefix('employee')->group(function() {
        Route::get('/', [EmployeeViewController::class, 'index'])->name("index");
        Route::get('/page/{any}', function() {return redirect('/employee');});
        Route::get('/page/', function() {return redirect('/employee');});
        Route::get('/switchstate/{id}/{state}', [EmployeeViewController::class, 'switchState'])->name('switchstate');
        Route::get('/delete/{id}', [EmployeeViewController::class, 'delete'])->name('delete');
        Route::post('/edit', [EmployeeViewController::class, 'edit'])->name('edit');
        Route::post('/specialization/add', [EmployeeViewController::class, 'addSpecialization'])->name("specialization.add");
        Route::get('/specialization/setstate/{id}/{state}/', [EmployeeViewController::class, 'setSpecializationState'])->name("specialization.setstate");
        Route::post('/role/add', [EmployeeRoleController::class, 'addRole'])->name("role.add");
        Route::post('/role/assign', [EmployeeRoleController::class, 'assignRoles'])->name("role.assign");
        Route::post('/role/addpermission', [EmployeeRoleController::class, 'addPermission'])->name("role.addpermission");
        Route::post('/role/removepermission/{id}', [EmployeeRoleController::class, 'removePermission'])->name("role.removepermission");
        Route::post('/role/switchstate/{id}',[EmployeeRoleController::class, 'switchRolePermission'])->name("role.switchstate");
        
        Route::post('/permission/switchstate/{id}',[EmployeePermissionController::class, 'permissionSwitchState'])->name("permission.switchstate");

        Route::get('/resources/{path}/', [EmployeeViewResourceLoader::class, 'manage'])->name('resource_loader');
    });

    Route::name('prepaidcards.')->prefix('prepaidcards')->group(function() {
        Route::get('/generate/{quantity}/{balance}', [PrepaidCardController::class, "generate"])->name('generate');
        Route::get('/deactivate/{id}', [PrepaidCardController::class, "deactivate"])->name('deactivate');
    });
});


/*
route("employee.index") -> 127.0.0.1:8000/employee/
route("employee.addspecialization") -> 127.0.0.1:8000/employee/addspecialization
*/