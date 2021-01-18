<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Http\Requests\CreateFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // ユーザーに紐づけてフォルダを保存する
        Auth::user()->folders()->save($folder);

        // 作成したフォルダのタスク一覧画面を表示する
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }
}
