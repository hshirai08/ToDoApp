<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFolder extends FormRequest
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
            'title' => 'required|max:20',
        ];
    }

    /**
     * エラーメッセージの項目名を日本語化
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'フォルダ名',
        ];
    }
}
