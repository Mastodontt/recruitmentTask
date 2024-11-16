<?php

namespace App\Http\Requests\Exercise;

use Illuminate\Foundation\Http\FormRequest;

class TaskEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
