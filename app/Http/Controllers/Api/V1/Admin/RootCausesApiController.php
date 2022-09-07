<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Root_Cause;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRootCauseRequest;
use App\Http\Requests\UpdateRootCauseRequest;
use App\Http\Resources\Admin\RootCauseResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RootCausesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('root_cause_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RootCauseResource(Root_Cause::with(['ticket', 'user'])->get());
    }

    public function store(StoreRootCauseRequest $request)
    {
        $root_cause = Root_Cause::create($request->all());

        return (new RootCauseResource($root_cause))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Root_Cause $root_cause)
    {
        abort_if(Gate::denies('root_cause_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RootCauseResource($root_cause->load(['ticket', 'user']));
    }

    public function update(UpdateRootCauseRequest $request, Root_Cause $root_cause)
    {
        $root_cause->update($request->all());

        return (new RootCauseResource($root_cause))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Root_Cause $root_cause)
    {
        abort_if(Gate::denies('root_cause_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $root_cause->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
