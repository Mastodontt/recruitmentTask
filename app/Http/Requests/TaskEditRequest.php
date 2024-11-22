<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class TaskEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
