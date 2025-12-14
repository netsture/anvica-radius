<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\EligibilityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RadiusUserController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;


Route::get('/', function () {  return view('site.index'); })->name('home');

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users/export-excel', [UserController::class, 'exportExcel'])->name('users.exportExcel');
    Route::get('/radius/user/export-excel', [RadiusUserController::class, 'exportExcel'])->name('radius.users.exportExcel');
    Route::get('/radius/users/logs/export', [RadiusUserController::class, 'exportUserLogs'])->name('radius.users.logs.export');
    Route::get('/radius/users/all/logs/export', [RadiusUserController::class, 'exportUserAllLogs'])->name('radius.users.all.logs.export');


    Route::controller(RadiusUserController::class)->group(function() {
        Route::get('/radius/user/index', 'index')->name('radius.users.index');
        Route::get('/radius/user/create', 'create')->name('radius.users.create');
        Route::post('/radius/user/store', 'store')->name('radius.users.store');
        Route::get('/radius/users/logs', 'logs')->name('radius.users.logs');
        Route::get('/radius/users/all/logs', 'allLogs')->name('radius.users.all.logs');
    });

    Route::get('/databases', [DatabaseController::class, 'databases'])->name('rows');
    Route::get('/databases/{database}/tables/{table}', [DatabaseController::class, 'rows'])->name('rows');

    Route::get('/advertisements/logs', [AdvertisementController::class, 'logs'])->name('advertisements.logs');
    Route::get('/advertisements/logs/history', [AdvertisementController::class, 'history'])->name('advertisements.logs.history');
    Route::get('/redirect', [AdvertisementController::class, 'redirectToUrl'])->name('hotspot.redirect');
    Route::resource('advertisements', AdvertisementController::class);
    

    Route::resource('users', UserController::class);
    Route::resource('identities', IdentityController::class);
    Route::resource('plans', PlanController::class);
    Route::resource('vouchers', VoucherController::class);
    Route::resource('rooms', RoomController::class);
    
    Route::post('/rooms/generate', [RoomController::class, 'generate'])->name('rooms.generate');

    Route::post('/vouchers/generate', [VoucherController::class, 'generate'])->name('vouchers.generate');
    // Route::get('/vouchers/show/{series}', [VoucherController::class, 'show'])->name('vouchers.show');
    
    Route::get('/vouchers/cards/{series}', [VoucherController::class, 'showCards'])->name('vouchers.cards');
    Route::get('/vouchers/pdf/{series}', [VoucherController::class, 'downloadPdf'])->name('vouchers.downloadPdf');
    Route::get('/vouchers/viewpdf/{series}', [VoucherController::class, 'showPdf'])->name('vouchers.viewPdf');


    Route::resource('options', OptionController::class)->except(['destroy']);
    Route::get('/options/delete/{id}', [OptionController::class, 'delete'])->name('options.delete');
    Route::get('/categories/search', [OptionController::class, 'search'])->name('categories.search');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
    Route::get('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

    Route::controller(RoleController::class)->group(function() {
        Route::get('/permissions', 'index')->name('permissions.index');
        Route::get('/permissions/create', 'create')->name('permissions.create');
        Route::post('/permissions/store', 'StorePermission')->name('permissions.store');
        Route::get('/permissions/edit/{id}', 'EditPermission')->name('permissions.edit');        
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');    

        Route::get('/roles', 'AllRoles')->name('roles.index');
        Route::get('/add/roles', 'AddRoles')->name('add.roles');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');

        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
        Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
        Route::get('/rolepermissions', 'AllRolesPermission')->name('rolepermissions.index');

        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');
        Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');
    });


});

Route::get('/cache/clear', function() {
    $exitCode = Artisan::call('optimize:clear');
    echo "Cache Clear Done..";
    // return what you want
});

require __DIR__.'/auth.php';

