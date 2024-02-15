<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    TokenController,
    CounterController,
    ServiceController,
    CounterUserController,
    DisplayController,
    ReportsController,
    AutomailController,
    ChartController
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//Open url
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/display', [DisplayController::class, 'index'])->name('index');
Route::get('/display-get/{service}/{section}', [DisplayController::class, 'display_ajax'])->name('display_ajax');
Route::get('/display-route/{service}/{section}', [DisplayController::class, 'display_route'])->name('display_route');

Route::get('/', function () {return redirect('/login');});

//admin url
Route::group(['middleware' => ['is_admin', 'auth']], function () {
    Route::get('/home', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/token', [TokenController::class, 'token_index'])->name('token_index');
    Route::post('/token-genrate', [TokenController::class, 'token_create'])->name('token_create');
    Route::get('/print-token/{id}', [TokenController::class, 'print_token'])->name('print_token');
    Route::get('/reprint-token/{id}', [TokenController::class, 'reprint_token'])->name('reprint_token');


    //admin
     Route::get('/new-user', [DashboardController::class, 'new_user'])->name('new_user');
     Route::post('/new-user', [DashboardController::class, 'create_user'])->name('create_user');
     Route::get('/edit-user/{id}', [DashboardController::class, 'edit_user'])->name('edit_user');
     Route::post('/edit-user/{id}', [DashboardController::class, 'update_user'])->name('update_user');


    Route::resource('/counter', CounterController::class);
    Route::resource('/service', ServiceController::class);

    Route::get('/assignCounters', [DashboardController::class, 'assign_counter'])->name('assign_counter');
    Route::post('/assign-counters', [DashboardController::class, 'assign_counter_no'])->name('assign_counter_no');
    Route::post('/delete-assign-counter/{id}', [DashboardController::class, 'delete_ass_counter'])->name('delete_ass_counter');


    Route::get('/newUser', [DashboardController::class, 'new_user'])->name('new_user');
    Route::post('/new-user', [DashboardController::class, 'create_user'])->name('create_user');
    Route::post('/delete-user/{id}', [DashboardController::class, 'destroy'])->name('delete_user');
    Route::get('/edit-user/{id}', [DashboardController::class, 'edit_user'])->name('edit_user');
    Route::post('/edit-user/{id}', [DashboardController::class, 'update_user'])->name('update_user');
    
    Route::get('/assignUser', [DashboardController::class, 'assign_user'])->name('assign_user');
    Route::post('/assign-user', [DashboardController::class, 'assign_user_no'])->name('assign_user_no');
    Route::post('/delete-assign-user/{id}', [DashboardController::class, 'delete_ass_user'])->name('delete_ass_user');

    Route::get('/counter-user', [CounterUserController::class, 'counter_user_index'])->name('counter_user_index');
    Route::post('/counter-refresh', [CounterUserController::class, 'counter_user_refreshcall'])->name('counter_user_refreshcall');
    Route::get('/counter-next/{id}/{next}', [CounterUserController::class, 'token_next'])->name('token_next');
    Route::get('/counter-cancel/{id}', [CounterUserController::class, 'token_cancel'])->name('token_cancel');
   
    Route::get('/auto-mail-add', [AutomailController::class, 'auto_mail_home'])->name('auto_mail_home');
    Route::post('/add-new-auto-mail', [AutomailController::class, 'add_auto_mail'])->name('add_auto_mail');
    Route::post('/delete-new-auto/{id}', [AutomailController::class, 'delete_auto_mail'])->name('delete_auto_mail');

    Route::get('/report-token-count', [ReportsController::class, 'token_count_home'])->name('token_count_home');
    Route::post('/report-token-count', [ReportsController::class, 'token_count'])->name('token_count');
   
    Route::get('/report-token-list', [ReportsController::class, 'token_list_home'])->name('token_list_home');
    Route::post('/report-token-list', [ReportsController::class, 'token_list'])->name('token_list');
    

    
    Route::get('/report-token-count-hour', [ReportsController::class, 'token_count_hour_home'])->name('token_count_hour_home');
    Route::post('/token-count-hour-counter-list', [ReportsController::class, 'token_count_hour_counter_list'])->name('token_count_hour_counter_list');
    Route::post('/token-count-hour-total-list', [ReportsController::class, 'token_count_hour_total_list'])->name('token_count_hour_total_list');
   
    Route::post('/hourly-token-count', [ChartController::class, 'chartData'])->name('chartData');
    
});


Route::group(['middleware' => ['is_counter','auth'] ], function () {
    Route::get('/counter-home', [CounterUserController::class, 'counter_user_index'])->name('counter_user_index');
    Route::post('/counter-refresh', [CounterUserController::class, 'counter_user_refreshcall'])->name('counter_user_refreshcall');
    Route::post('/counter-next/call', [CounterUserController::class, 'counter_token_call'])->name('counter_token_call');
    Route::get('/counter-next/{id}/{next}', [CounterUserController::class, 'token_next'])->name('token_next');
    Route::get('/counter-cancel/{id}', [CounterUserController::class, 'token_cancel'])->name('token_cancel');
    Route::get('/counter-activate/{ativate}', [CounterUserController::class, 'counter_activate'])->name('counter_activate');
    Route::get('/counter-token-list', [CounterUserController::class, 'counter_token_list_ajax'])->name('counter_token_list_ajax');
    Route::get('/select-call-token/{id}', [CounterUserController::class, 'counter_token_select_call_ajax'])->name('counter_token_select_call_ajax');
});



Route::group(['middleware' => ['is_token','auth']], function () {
    Route::get('/token-home', [TokenController::class, 'token_index'])->name('token_index');
    Route::get('/token-list', [TokenController::class, 'token_list_ajax'])->name('token_list_ajax');
    Route::post('/token-genrate', [TokenController::class, 'token_create'])->name('token_create');
    Route::get('/reprint-token/{id}', [TokenController::class, 'reprint_token'])->name('reprint_token');

});

Route::group(['middleware' => ['is_report','auth','web']], function () {
    Route::get('/report-home', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/report-token-count', [ReportsController::class, 'token_count_home'])->name('token_count_home');
    Route::post('/report-token-count', [ReportsController::class, 'token_count'])->name('token_count');
   
    Route::get('/report-token-list', [ReportsController::class, 'token_list_home'])->name('token_list_home');
    Route::post('/report-token-list', [ReportsController::class, 'token_list'])->name('token_list');

    
    Route::get('/report-token-count-hour', [ReportsController::class, 'token_count_hour_home'])->name('token_count_hour_home');
    Route::post('/token-count-hour-counter-list', [ReportsController::class, 'token_count_hour_counter_list'])->name('token_count_hour_counter_list');
    Route::post('/token-count-hour-total-list', [ReportsController::class, 'token_count_hour_total_list'])->name('token_count_hour_total_list');
   
   
});



