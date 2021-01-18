<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * GET /
     * ホーム画面を表示する
     */
    public function index(Folder $folder)
    {
        // ログインユーザーを取得する
        $user = Auth::user();
        // ログインユーザーに紐づくフォルダを一つ取得する
        $folder = $user->folders()->first();

        // 一つもフォルダを作成していない場合はホームページを表示する
        if (is_null($folder)) {
            return view('home');
        }
        // 既にフォルダがある場合はタスク一覧画面を表示する
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }
}
