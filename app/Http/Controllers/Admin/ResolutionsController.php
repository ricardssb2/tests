<?php

namespace App\Http\Controllers\Admin;

use App\Resolution;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyResolutionRequest;
use App\Http\Requests\StoreResolutionRequest;
use App\Http\Requests\UpdateResolutionRequest;
use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolutionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('resolution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resolutions = Resolution::all();

        return view('admin.resolutions.index', compact('resolutions'));
    }

    public function create()
    {
        abort_if(Gate::denies('resolution_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.resolutions.create', compact('tickets', 'users'));
    }

    public function store(StoreResolutionRequest $request)
    {
        $resolution = Resolution::create($request->all());

        return redirect()->route('admin.resolutions.index');
    }

    public function edit(Resolution $resolution)
    {
        abort_if(Gate::denies('resolution_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resolution->load('ticket', 'user');

        return view('admin.resolutions.edit', compact('tickets', 'users', 'resolution'));
    }

    public function update(UpdateResolutionRequest $request, Resolution $resolution)
    {
        $resolution->update($request->all());

        return redirect()->route('admin.resolutions.index');
    }

    public function show(Resolution $resolution)
    {
        abort_if(Gate::denies('resolution_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resolution->load('ticket', 'user');

        return view('admin.resolutions.show', compact('resolution'));
    }

    public function destroy(Resolution $resolution)
    {
        abort_if(Gate::denies('resolution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resolution->delete();

        return back();
    }

    public function massDestroy(MassDestroyResolutionRequest $request)
    {
        Resolution::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
