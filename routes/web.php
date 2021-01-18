<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FolderController;
use Illuminate\Support\Facades\Auth;

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

// ユーザーの認証状態を確認して、ログインしていなければログイン画面を表示する
Route::group(['middleware' => 'auth'], function () {

    // ホーム画面を表示する
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // フォルダを作成する
    Route::get('/folders/create', [FolderController::class, 'showCreateForm'])->name('folders.create');
    Route::post('/folders/create', [FolderController::class, 'create']);

    Route::group(['middleware' => 'can:view,folder'], function () {
        // 選ばれたフォルダのタスク一覧を表示する
        Route::get('/folders/{folder}/tasks', [TaskController::class, 'index'])->name('tasks.index');

        // タスクを作成する
        Route::get('/folders/{folder}/tasks/create', [TaskController::class, 'showCreateForm'])->name('tasks.create');
        Route::post('/folders/{folder}/tasks/create', [TaskController::class, 'create']);

        // タスクを編集する
        Route::get('/folders/{folder}/tasks/{task}/edit', [TaskController::class, 'showEditForm'])->name('tasks.edit');
        Route::post('folders/{folder}/tasks/{task}/edit', [TaskController::class, 'edit']);
    });
});

// 会員登録・ログイン・ログアウト・パスワード再設定を行う
Auth::routes();
