<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class TaskDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
