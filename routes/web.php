<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanyController;



//Company
Route::get('/companies', [App\Http\Controllers\CompanyController::class, 'index']) ->name('companies');
Route::post('/company', [CompanyController::class, 'store'])->name('company.store');
Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
Route::delete('/company/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');


// Main Page
Route::get('/mainpage', [App\Http\Controllers\MainPageController::class, 'index'])->name('mainpage');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', 'TicketController@create');
});


Route::get('/home', function () {
    $route = Gate::denies('dashboard_access') ? 'admin.tickets.index' : 'admin.home';
    if (session('status')) {
        return redirect()->route($route)->with('status', session('status'));
    }

    return redirect()->route($route);
});

Auth::routes(['register' => true]);

Route::post('tickets/media', 'TicketController@storeMedia')->name('tickets.storeMedia');
Route::post('tickets/comment/{ticket}', 'TicketController@storeComment')->name('tickets.storeComment');
Route::post('tickets/analyse/{ticket}', 'TicketController@storeAnalyse')->name('tickets.storeAnalyse');
Route::post('tickets/detail/{ticket}', 'TicketController@storeDetail')->name('tickets.storeDetail');
Route::post('tickets/resolution/{ticket}', 'TicketController@storeResolution')->name('tickets.storeResolution');
Route::post('tickets/root_cause/{ticket}', 'TicketController@storeRootCause')->name('tickets.storeRootCause');
Route::resource('tickets', 'TicketController')->only(['show', 'create', 'store']);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Statuses
    Route::delete('statuses/destroy', 'StatusesController@massDestroy')->name('statuses.massDestroy');
    Route::resource('statuses', 'StatusesController');

    // Priorities
    Route::delete('priorities/destroy', 'PrioritiesController@massDestroy')->name('priorities.massDestroy');
    Route::resource('priorities', 'PrioritiesController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoriesController');

    // Tickets
    Route::delete('tickets/destroy', 'TicketsController@massDestroy')->name('tickets.massDestroy');
    Route::post('tickets/media', 'TicketsController@storeMedia')->name('tickets.storeMedia');
    Route::post('tickets/comment/{ticket}', 'TicketsController@storeComment')->name('tickets.storeComment');
    Route::post('tickets/analyse/{ticket}', 'TicketsController@storeAnalyse')->name('tickets.storeAnalyse');
    Route::post('tickets/detail/{ticket}', 'TicketsController@storeDetail')->name('tickets.storeDetail');
    Route::post('tickets/resolution/{ticket}', 'TicketsController@storeResolution')->name('tickets.storeResolution');
    Route::post('tickets/root_cause/{ticket}', 'TicketsController@storeRootCause')->name('tickets.storeRootCause');
    Route::get('tickets/open','TicketsController@openticket')->name('tickets.list.open');
    Route::get('tickets/pending','TicketsController@pendingticket')->name('tickets.list.pending');
    Route::get('tickets/archive','TicketsController@archive')->name('tickets.list.archive');
    Route::get('tickets/list','TicketsController@filteredTickets')->name('tickets.list');
    Route::resource('tickets', 'TicketsController');

    //assigning to user
    Route::get('assign_user','TicketsController@assignUser');


    // Comments
    Route::delete('comments/destroy', 'CommentsController@massDestroy')->name('comments.massDestroy');
    Route::resource('comments', 'CommentsController');

    // Analyses
    Route::delete('analyses/destroy', 'AnalysesController@massDestroy')->name('analyses.massDestroy');
    Route::resource('analyses', 'AnalysesController');

    // Details
    Route::delete('details/destroy', 'DetailsController@massDestroy')->name('details.massDestroy');
    Route::resource('details', 'DetailsController');

    // Resolution
    Route::delete('resolutions/destroy', 'ResolutionsController@massDestroy')->name('resolutions.massDestroy');
    Route::resource('resolutions', 'ResoltuionsController');

    // Root Cause
    Route::delete('root_causes/destroy', 'RootCausesController@massDestroy')->name('root_causes.massDestroy');
    Route::resource('root_causes', 'RootCausesController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Main Page
    
});
Route::resource('users','TestController'); // user ajax table
