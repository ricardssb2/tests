<?php

namespace App\Http\Requests;

use App\Resolution;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateResolutionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('resolution_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'author_name'  => [
                'required',
            ],
            'author_email' => [
                'required',
            ],
            'resolution_text' => [
                'required',
            ],
        ];
    }
}
