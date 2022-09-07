<?php

namespace App\Http\Controllers\Admin;

use App\Detail;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDetailRequest;
use App\Http\Requests\StoreDetailRequest;
use App\Http\Requests\UpdateDetailRequest;
use App\Ticket;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetailsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $details = Detail::all();

        return view('admin.details.index', compact('details'));
    }

    public function create()
    {
        abort_if(Gate::denies('detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.details.create', compact('tickets', 'users'));
    }

    public function store(StoreDetailRequest $request)
    {
        $detail = Detail::create($request->all());

        return redirect()->route('admin.details.index');
    }

    public function edit(Detail $detail)
    {
        abort_if(Gate::denies('detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $detail->load('ticket', 'user');

        return view('admin.details.edit', compact('tickets', 'users', 'detail'));
    }

    public function update(UpdateDetailRequest $request, Detail $detail)
    {
        $detail->update($request->all());

        return redirect()->route('admin.details.index');
    }

    public function show(Detail $detail)
    {
        abort_if(Gate::denies('detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $detail->load('ticket', 'user');

        return view('admin.details.show', compact('detail'));
    }

    public function destroy(Detail $detail)
    {
        abort_if(Gate::denies('detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $detail->delete();

        return back();
    }

    public function massDestroy(MassDestroyDetailRequest $request)
    {
        Detail::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
