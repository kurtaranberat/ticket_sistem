<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProblemController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Cozen\CozumlerController;
use App\Http\Controllers\Kullanici\SorunlarController;
use App\Http\Controllers\MesajController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');

    Route::prefix('roles')->group(function () {
        Route::resource('/', RoleController::class);
        Route::post('/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
        Route::delete('/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    });

    Route::prefix('permissions')->group(function () {
        Route::resource('/', PermissionController::class);
        Route::post('/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
        Route::delete('/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
        Route::delete('/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
        Route::post('/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
        Route::delete('/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');
    });

    Route::prefix('ticket')->group(function (){
        Route::get('/',[TicketController::class,'index'])->name('ticket.index');
    });

    Route::get('/problem', [ProblemController::class, 'index'])->name('problem.index');
});


Route::middleware(['auth', 'role:kullanici'])->name('kullanici.')->prefix('kullanici')->group(function () {
   Route::get('/',[SorunlarController::class,'index'])->name('index');
   Route::get('/cozenFetch',[SorunlarController::class , 'cozenFetch'])->name('cozenFetch');
   Route::get('/Sorunlar/{id}',[SorunlarController::class,'sor'])->name('panel.index');
   Route::post('/Sorunlar/message/post',[SorunlarController::class,'messagePost'])->name('panel.message.post');
   Route::get('/Sorunlar/message/get',[SorunlarController::class,'messageGet'])->name('panel.message.get');

});

Route::middleware(['auth', 'role:cozen'])->name('cozen.')->prefix('cozen')->group(function () {
    Route::get('/',[CozumlerController::class,'index'])->name('index');
    Route::get('/listeleFetch',[CozumlerController::class , 'listeleFetch'])->name('listeleFetch');
    Route::get('/Cozumler/{id}',[CozumlerController::class,'coz'])->name('panel.index');
    Route::post('/Cozumler/message/post',[CozumlerController::class,'messagePost'])->name('panel.message.post');
    Route::get('/Cozumler/message/get',[CozumlerController::class,'messageGet'])->name('panel.message.get');
});







































Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::resource('/roles', RoleController::class);
    Route::get('/problem',[ProblemController::class,'index'])->name('problem.index');

    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::resource('/permissions', PermissionController::class);
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');
});


require __DIR__ . '/auth.php';
