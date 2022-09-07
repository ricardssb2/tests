<?php

namespace App\Http\Requests;

use App\Analyse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAnalyseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('analyse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:comments,id',
        ];
    }
}
