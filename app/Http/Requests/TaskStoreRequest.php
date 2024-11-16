<?php

namespace App\Http\Requests\Exercise;

final class TaskStoreRequest extends TaskBaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return parent::rules();
    }
}
