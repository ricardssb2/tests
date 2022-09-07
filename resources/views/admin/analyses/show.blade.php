@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.analyse.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.analyse.fields.id') }}
                        </th>
                        <td>
                            {{ $analyse->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analyse.fields.ticket') }}
                        </th>
                        <td>
                            {{ $analyse->ticket->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analyse.fields.author_name') }}
                        </th>
                        <td>
                            {{ $analyse->author_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analyse.fields.author_email') }}
                        </th>
                        <td>
                            {{ $analyse->author_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analyse.fields.user') }}
                        </th>
                        <td>
                            {{ $analyse->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.analyse.fields.analyse_text') }}
                        </th>
                        <td>
                            {!! $analyse->analyse_text !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection