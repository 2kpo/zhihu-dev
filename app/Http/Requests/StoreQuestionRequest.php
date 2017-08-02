<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
                'title' => 'required|min:6|max:150',
                'body' => 'required|min:15'
            ];
        }

        public function messages()
        {
            return [
                'required' => ':attribute不能为空',
                'min' => ':attribute最少为:min个字符',
                'max' => ':attribute最多为:max个字符'
            ];
        }

        public function attributes()
        {
            return [
                'title' => '问题标题',
                'body' => '问题内容'
            ];
        }
}
