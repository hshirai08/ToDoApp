<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Validation\Rule;

class EditTask extends CreateTask
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // タイトル、期限日のバリデーションはタスク作成時と同じルールを使用する
        $rule = parent::rules();
        // 状態は選択肢以外入力できないように設定する
        $status_rule = Rule::in(array_keys(Task::STATUS));

        return $rule + [
            'status' => 'required|' . $status_rule,
        ];
    }

    /**
     * エラーメッセージの項目名を日本語化
     * @return array
     */
    public function attributes()
    {
        // 入力した項目を取得する
        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態',
        ];
    }

    /**
     * statusのinのエラーメッセージを日本語化
     * @return array
     */
    public function messages()
    {
        // 継承元のエラーメッセージを取得する
        $messages = parent::messages();
        // 状態の選択肢の配列を作成する
        $status_labels = array_map(function ($item) {
            return $item['label'];
        }, Task::STATUS);
        // 配列の要素を「、」によって連結する
        $status_labels = implode('、', $status_labels);

        return $messages + [
            'status.in' => ':attribute には ' . $status_labels . ' のいずれかを指定してください。',
        ];
    }
}
