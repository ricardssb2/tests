<?php

namespace App\Http\Requests;

use App\Root_Cause;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRootCauseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('root_cause_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
