<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class TaskCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
