<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * GET /folders/{id}/tasks
     * タスク一覧画面を表示する
     */
    public function index(int $id)
    {
        // 全てのフォルダを取得する
        $folders = Folder::all();
        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);
        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = $current_folder->tasks()->get();

        // テンプレートに全てのフォルダの情報、選ばれたフォルダのID、選ばれたフォルダに紐づくタスクの情報を渡してHTMLを生成する
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/create
     * タスク作成画面を表示する
     */
    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    /**
     * POST /folders/{id}/tasks/create
     * タスクを保存する
     */
    public function create(int $id, CreateTask $request)
    {
        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);
        // 追加するタスクのインスタンスを作成する
        $task = new Task();
        // タスクのタイトルと期限日に入力値を設定する
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        // 追加されたタスクを保存する
        $current_folder->tasks()->save($task);

        // 選ばれたフォルダのタスク一覧画面を表示する
        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/{task_id}/edit
     * タスク編集画面を表示する
     */
    public function showEditForm(int $id, int $task_id)
    {
        // 選ばれたタスクを取得
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * POST /folders/{id}/tasks/{task_id}/edit
     * 編集したタスクを保存する
     */
    public function edit(int $id, int $task_id, EditTask $request)
    {
        // 編集されたタスクを取得する
        $task = Task::find($task_id);
        // タスクのタイトル、状態、期限日に入力値を設定する
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        // 編集されたタスクを保存する
        $task->save();

        // タスク一覧画面を表示する
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}
