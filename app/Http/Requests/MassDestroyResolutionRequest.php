<?php

namespace App\Http\Requests;

use App\Resolution;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyResolutionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('resolution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
