<?php

namespace App\Http\Requests;

use App\Enums\DomainRuleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreDomainRuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'domain_rules' => [
                'required',
                'array',
                'min:1',
            ],
            'domain_rules.*.alert_text' => [
                'required',
                'string',
                'max:100',
            ],
            'domain_rules.*.rules' => [
                'required',
                'array',
                'min:1',
            ],
            'domain_rules.*.rules.*.show_alert' => [
                'required',
                'boolean',
            ],
            'domain_rules.*.rules.*.rule' => [
                'required',
                new Enum(DomainRuleEnum::class),
            ],
            'domain_rules.*.rules.*.page' => [
                'nullable',
                'string',
                'max:100',
            ],
        ];
    }
}
