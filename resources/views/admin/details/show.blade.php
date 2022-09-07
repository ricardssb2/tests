@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.detail.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.detail.fields.id') }}
                        </th>
                        <td>
                            {{ $detail->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.detail.fields.ticket') }}
                        </th>
                        <td>
                            {{ $detail->ticket->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.detail.fields.author_name') }}
                        </th>
                        <td>
                            {{ $detail->author_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.detail.fields.author_email') }}
                        </th>
                        <td>
                            {{ $detail->author_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.detail.fields.user') }}
                        </th>
                        <td>
                            {{ $detail->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.detail.fields.detail_text') }}
                        </th>
                        <td>
                            {!! $detail->detail_text !!}
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