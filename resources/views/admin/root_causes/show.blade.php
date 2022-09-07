@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.root_cause.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.root_cause.fields.id') }}
                        </th>
                        <td>
                            {{ $root_cause->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.root_cause.fields.ticket') }}
                        </th>
                        <td>
                            {{ $root_cause->ticket->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.root_cause.fields.author_name') }}
                        </th>
                        <td>
                            {{ $root_cause->author_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.root_cause.fields.author_email') }}
                        </th>
                        <td>
                            {{ $root_cause->author_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.root_cause.fields.user') }}
                        </th>
                        <td>
                            {{ $root_cause->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.root_cause.fields.root_cause_text') }}
                        </th>
                        <td>
                            {!! $root_cause->root_cause_text !!}
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