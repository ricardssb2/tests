<?php

namespace App\Http\Requests;

use App\Analyse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreAnalyseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('analyse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'analyse_text' => [
                'required',
            ],
        ];
    }
}
