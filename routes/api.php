<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Statuses
    Route::apiResource('statuses', 'StatusesApiController');

    // Priorities
    Route::apiResource('priorities', 'PrioritiesApiController');

    // Categories
    Route::apiResource('categories', 'CategoriesApiController');

    // Tickets
    Route::post('tickets/media', 'TicketsApiController@storeMedia')->name('tickets.storeMedia');
    Route::post('tickets/open', 'TicketsApiController@openticket')->name('tickets.list.open');
    Route::post('tickets/pending', 'TicketsApiController@pendingticket')->name('tickets.list.pending');
    Route::post('tickets/archive', 'TicketsApiController@archive')->name('tickets.list.archive');
    //Route::post('tickets/list', 'TicketsApiController@filteredTickets')->name('tickets.list');
    Route::apiResource('tickets', 'TicketsApiController');

    // Comments
    Route::apiResource('comments', 'CommentsApiController');

    // Analyses
    Route::apiResource('analyses', 'AnalysesApiController');

    // Details
    Route::apiResource('details', 'DetailsApiController');

    // Resolutions
    Route::apiResource('resolutions', 'ResolutionsApiController');

    // Root Causes
    Route::apiResource('root_causes', 'RootCausesApiController');
});
