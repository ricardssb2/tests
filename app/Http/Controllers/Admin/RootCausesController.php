<?php

namespace App\Http\Controllers\Admin;

use App\Root_Cause;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRootCauseRequest;
use App\Http\Requests\StoreRootCauseRequest;
use App\Http\Requests\UpdateRootCauseRequest;
use App\Ticket;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RootCausesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('root_cause_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $root_causes = Root_Cause::all();

        return view('admin.root_causes.index', compact('root_causes'));
    }

    public function create()
    {
        abort_if(Gate::denies('root_cause_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.root_causes.create', compact('tickets', 'users'));
    }

    public function store(StoreRootCauseRequest $request)
    {
        $root_cause = Root_Cause::create($request->all());

        return redirect()->route('admin.root_causes.index');
    }

    public function edit(Root_Cause $root_cause)
    {
        abort_if(Gate::denies('root_cause_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $root_cause->load('ticket', 'user');

        return view('admin.root_causes.edit', compact('tickets', 'users', 'root_cause'));
    }

    public function update(UpdateRootCauseRequest $request, Root_Cause $root_cause)
    {
        $root_cause->update($request->all());

        return redirect()->route('admin.root_causes.index');
    }

    public function show(Root_Cause $root_cause)
    {
        abort_if(Gate::denies('root_cause_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $root_cause->load('ticket', 'user');

        return view('admin.root_causes.show', compact('root_cause'));
    }

    public function destroy(Root_Cause $root_cause)
    {
        abort_if(Gate::denies('root_cause_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $root_cause->delete();

        return back();
    }

    public function massDestroy(MassDestroyRootCauseRequest $request)
    {
        Root_Cause::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
