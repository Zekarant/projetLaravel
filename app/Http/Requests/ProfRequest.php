<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ProfRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->prof ? ',' . $this->prof->id : '';

        return $rules = [
            'name' => 'required|string|max:255|unique:profs,name' . $id,
        ];
    }
}
