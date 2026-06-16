<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\CompanyParser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'city' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'provider' => ['required', 'string', Rule::in(array_keys(config('company_parser.providers', [])))],
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
