<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function wantsJson()
    {
        dd(11);
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
            'subject' => 'required|string|min:3',
            'body' => 'required|string|min:10',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'subject.required' => 'Заголовок комментария обязателен к заполнению',
            'body.required' => 'Описание обязательно к заполнению',
            'subject.min' => 'Заголовок должен содержать минимум 3 символа',
            'body.min' => 'Описание должно содержать минимум 10 символов',
        ];
    }
}
