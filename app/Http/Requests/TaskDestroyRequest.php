<?php

namespace App\Http\Requests\Exercise;

use Illuminate\Foundation\Http\FormRequest;

class TaskDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
