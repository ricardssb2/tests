@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.resolution.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.resolution.fields.id') }}
                        </th>
                        <td>
                            {{ $resolution->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resolution.fields.ticket') }}
                        </th>
                        <td>
                            {{ $resolution->ticket->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resolution.fields.author_name') }}
                        </th>
                        <td>
                            {{ $resolution->author_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resolution.fields.author_email') }}
                        </th>
                        <td>
                            {{ $resolution->author_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resolution.fields.user') }}
                        </th>
                        <td>
                            {{ $resolution->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resolution.fields.resolution_text') }}
                        </th>
                        <td>
                            {!! $resolution->resolution_text !!}
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