<?php

namespace App\Http\Requests;

use App\Enums\Image\ImageViewsEnum;
use App\Http\Rules\ColorRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ViewRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return \auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $default = [
            'name' => ['required', 'string', 'unique:views'],
            'type' => ['required', Rule::in(ImageViewsEnum::enums())],
            'width' => ['required', 'integer', 'min:50'],
            'height' => ['required', 'integer', 'min:50'],
            'color' => ['string', new ColorRule()],
        ];

        return $default;
    }

}
