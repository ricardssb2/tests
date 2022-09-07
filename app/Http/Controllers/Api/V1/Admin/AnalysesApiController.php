<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Analyse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnalyseRequest;
use App\Http\Requests\UpdateAnalyseRequest;
use App\Http\Resources\Admin\AnalyseResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnalysesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('analyse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AnalyseResource(Analyse::with(['ticket', 'user'])->get());
    }

    public function store(StoreAnalyseRequest $request)
    {
        $analyse = Analyse::create($request->all());

        return (new AnalyseResource($analyse))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Analyse $analyse)
    {
        abort_if(Gate::denies('analyse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AnalyseResource($analyse->load(['ticket', 'user']));
    }

    public function update(UpdateAnalyseRequest $request, Analyse $analyse)
    {
        $analyse->update($request->all());

        return (new AnalyseResource($analyse))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Analyse $analyse)
    {
        abort_if(Gate::denies('analyse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $analyse->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
