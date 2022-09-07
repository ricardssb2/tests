<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Resolution;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResolutionRequest;
use App\Http\Requests\UpdateResolutionRequest;
use App\Http\Resources\Admin\ResolutionResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolutionsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('resolution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ResolutionResource(Resolution::with(['ticket', 'user'])->get());
    }

    public function store(StoreResolutionRequest $request)
    {
        $resolution = Resolution::create($request->all());

        return (new ResolutionResource($resolution))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Resolution $resolution)
    {
        abort_if(Gate::denies('resolution_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ResolutionResource($resolution->load(['ticket', 'user']));
    }

    public function update(UpdateResolutionRequest $request, Resolution $resolution)
    {
        $resolution->update($request->all());

        return (new ResolutionResource($resolution))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Resolution $resolution)
    {
        abort_if(Gate::denies('resolution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resolution->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
