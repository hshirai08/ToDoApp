<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Http\Requests\CreateFolder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * GET /folders/create
     * フォルダ作成画面を表示する
     */
    public function showCreateForm()
    {
        return view('folders/create');
    }

    /**
     * POST /folders/create
     * フォルダを保存する
     */
    public function create(CreateFolder $request)
    {
        // フォルダモデルのインスタンスを作成する
        $folder = new Folder();
        // タイトルに入力値を代入する
        $folder->title = $request->title;
        // インスタンスの状態をデータベースに書き込む
        $folder->save();

        // 作成したフォルダのタスク一覧画面を表示する
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
