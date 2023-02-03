<?php

namespace App\Http\Controllers\Admin;

use App\Analyse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAnalyseRequest;
use App\Http\Requests\StoreAnalyseRequest;
use App\Http\Requests\UpdateAnalyseRequest;
use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnalysesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('analyse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $analyses = Analyse::all();

        return view('admin.analyses.index', compact('analyses'));
    }

    public function create()
    {
        abort_if(Gate::denies('analyse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.analyses.create', compact('tickets', 'users'));
    }

    public function store(StoreAnalyseRequest $request)
    {
        $analyse = Analyse::create($request->all());

        return redirect()->route('admin.analyses.index');
    }

    public function edit(Analyse $analyse)
    {
        abort_if(Gate::denies('analyse_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $analyse->load('ticket', 'user');

        return view('admin.analyses.edit', compact('tickets', 'users', 'analyse'));
    }

    public function update(UpdateAnalyseRequest $request, Analyse $analyse)
    {
        $analyse->update($request->all());

        return redirect()->route('admin.analyses.index');
    }

    public function show(Analyse $analyse)
    {
        abort_if(Gate::denies('analyse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $analyse->load('ticket', 'user');

        return view('admin.analyses.show', compact('analyse'));
    }

    public function destroy(Analyse $analyse)
    {
        abort_if(Gate::denies('analyse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $analyse->delete();

        return back();
    }

    public function massDestroy(MassDestroyAnalyseRequest $request)
    {
        Analyse::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
