<?php

namespace App\Http\Requests;

use App\Enums\Image\ImageFormatsEnum;
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
        return [
            'format' => [Rule::in(ImageFormatsEnum::enums())],
            'name' => ['required', 'string'],
            'type' => ['required', Rule::in(ImageViewsEnum::enums())],
            'width' => ['required', 'integer', 'min:50', 'max:8000'],
            'height' => ['required', 'integer', 'min:50', 'max:8000'],
            'color' => ['string', new ColorRule()],
            'optimize' => ['boolean'],
        ];
    }

}
