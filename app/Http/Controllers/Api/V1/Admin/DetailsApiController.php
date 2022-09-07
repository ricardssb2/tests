<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Detail;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDetailRequest;
use App\Http\Requests\UpdateDetailRequest;
use App\Http\Resources\Admin\DetailResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetailsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DetailResource(Detail::with(['ticket', 'user'])->get());
    }

    public function store(StoreDetailRequest $request)
    {
        $detail = Detail::create($request->all());

        return (new DetailResource($detail))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Detail $detail)
    {
        abort_if(Gate::denies('detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DetailResource($detail->load(['ticket', 'user']));
    }

    public function update(UpdateDetailRequest $request, Detail $detail)
    {
        $detail->update($request->all());

        return (new DetailResource($detail))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Detail $detail)
    {
        abort_if(Gate::denies('detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $detail->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
