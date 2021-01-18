<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\Auth\RegisterController;

class UserTest extends TestCase
{
    // テストケースごとにデータベースをリフレッシュしてマイグレーションを再実行する
    use RefreshDatabase;

    /**
     * 各テストメソッドの実行前に呼ばれる
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * ユーザー名が文字列でない場合はバリデーションエラー
     * @test
     */
    public function name_should_be_string()
    {
        $response = $this->post('/register', [
            'email' => 'test@email.com',
            'name' => 123, // 不正なデータ（数値）
            'password' => bcrypt('test1234'),
        ]);

        $response->assertSessionHasErrors([
            'name' => 'ユーザー名 には文字を入力してください。',
        ]);
    }
}
