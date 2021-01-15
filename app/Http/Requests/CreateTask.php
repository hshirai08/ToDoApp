<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // リクエストの内容に基づいた権限チャックは行わない
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100',
            'due_date' => 'required|date|after_or_equal:today',
        ];
    }

    /**
     * エラーメッセージの項目名を日本語化
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'due_date' => '期限日',
        ];
    }

    /**
     * due_dateのafter_or_equal:todayのエラーメッセージを日本語化
     * @return array
     */
    public function messages()
    {
        return [
            'due_date.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
        ];
    }
}
