<?php

namespace App\Http\Requests;

use Domain\Rooms\Models\RoomType;
use Domain\Tenants\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string:255'],
            'types' => ['required', 'array'],
            'types.*' => Rule::forEach(function ($value, $attribute) {
                return [
                    Rule::exists(RoomType::class, 'id'),
                ];
            })
        ];
    }
}
