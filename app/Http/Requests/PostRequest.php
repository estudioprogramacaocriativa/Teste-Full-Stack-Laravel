<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        if(!empty($this->author)):
            $this->merge(['user_id' => $this->author]);
        endif;
    }

    public function rules()
    {
        $rule = [
            'title' => [
                'required',
                Rule::unique('posts')->ignore($this->id)
            ],
            'body' => 'required',
            'author' => 'required',
            'status' => 'required',
        ];

        if(!empty($this->image)):
            $rule['image'] = 'image';
        endif;

        return $rule;
    }

    public function messages()
    {
        return [
            'title.unique' => "O título <b>{$this->title}</b> já existe!#show_error",
            'image.image' => "São permitidas apenas imagens do tipo JPEG, JPG, PGN ou GIF!#show_error"
        ];
    }
}
