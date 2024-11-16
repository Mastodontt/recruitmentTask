<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

abstract class FilteredRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    final public function rules(): array
    {
        return $this->requestRules();
    }

    protected function requestRules(): array
    {
        return [];
    }

    abstract public function applyFilters(Builder $query): Builder;

    abstract public function getBaseQuery(): Builder;

    final public function filter(): Builder
    {
        return $this->applyFilters($this->getBaseQuery());
    }
}
