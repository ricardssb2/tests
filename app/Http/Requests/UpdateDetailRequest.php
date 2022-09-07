<?php

namespace App\Http\Requests;

use App\Detail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateDetailRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'detail_text' => [
                'required',
            ],
        ];
    }
}
