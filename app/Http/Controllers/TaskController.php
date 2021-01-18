<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * GET /folders/{folder}/tasks
     * タスク一覧画面を表示する
     */
    public function index(Folder $folder)
    {
        // ログインユーザーのフォルダを取得する
        $folders = Auth::user()->folders()->get();
        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = $folder->tasks()->get();

        // テンプレートに全てのフォルダの情報、選ばれたフォルダのID、選ばれたフォルダに紐づくタスクの情報を渡してHTMLを生成する
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * GET /folders/{folder}/tasks/create
     * タスク作成画面を表示する
     */
    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder' => $folder->id,
        ]);
    }

    /**
     * POST /folders/{folder}/tasks/create
     * タスクを保存する
     */
    public function create(Folder $folder, CreateTask $request)
    {
        // 追加するタスクのインスタンスを作成する
        $task = new Task();
        // タスクのタイトルと期限日に入力値を設定する
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        // 追加されたタスクを保存する
        $folder->tasks()->save($task);

        // 選ばれたフォルダのタスク一覧画面を表示する
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    /**
     * GET /folders/{folder}/tasks/{task}/edit
     * タスク編集画面を表示する
     */
    public function showEditForm(Folder $folder, Task $task)
    {
        // フォルダとタスクが紐づいていない場合は 404 を返す
        $this->checkRelation($folder, $task);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * POST /folders/{folder}/tasks/{task}/edit
     * 編集したタスクを保存する
     */
    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        // フォルダとタスクが紐づいていない場合は 404 を返す
        $this->checkRelation($folder, $task);

        // タスクのタイトル、状態、期限日に入力値を設定する
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        // 編集されたタスクを保存する
        $task->save();

        // タスク一覧画面を表示する
        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }

    /**
     * フォルダとタスクが紐づいていない場合は 404 を返す
     */
    private function checkRelation(Folder $folder, Task $task)
    {
        if ($folder->id !== $task->folder_id) {
            abort(404);
        }
    }
}
