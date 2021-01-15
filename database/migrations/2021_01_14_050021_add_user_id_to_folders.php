<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToFolders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('folders', function (Blueprint $table) {
            // foldersテーブルのカラムにユーザーIDを追加する
            $table->bigInteger('user_id')->unsigned();

            // 外部キーを設定する
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('folders', function (Blueprint $table) {
            // foldersテーブルからユーザーIDのカラムを削除する
            $table->dropForeign(['user_id']);
        });
    }
}
