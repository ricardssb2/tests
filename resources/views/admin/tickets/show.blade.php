@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ticket.title') }}
    </div>

    <div class="card-body">
        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.id') }}
                        </th>
                        <td>
                            {{ $ticket->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.created_at') }}
                        </th>
                        <td>
                            {{ $ticket->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $ticket->updated_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.title') }}
                        </th>
                        <td>
                            {{ $ticket->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.content') }}
                        </th>
                        <td>
                            {!! $ticket->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.attachments') }}
                        </th>
                        <td>
                            @foreach($ticket->attachments as $attachment)
                                <a href="{{ $attachment->getUrl() }}" target="_blank">{{ $attachment->file_name }}</a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.status') }}
                        </th>
                        <td>
                            {{ $ticket->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.priority') }}
                        </th>
                        <td>
                            {{ $ticket->priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.category') }}
                        </th>
                        <td>
                            {{ $ticket->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.author_name') }}
                        </th>
                        <td>
                            {{ $ticket->author_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.author_email') }}
                        </th>
                        <td>
                            {{ $ticket->author_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.assigned_to_user') }}
                        </th>
                        <td>
                            {{ $ticket->assigned_to_user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.comments') }}
                        </th>
                        <td>
                            @forelse ($ticket->comments as $comment)
                                <div class="row">
                                    <div class="col">
                                        <p class="font-weight-bold"><a href="mailto:{{ $comment->author_email }}">{{ $comment->author_name }}</a> ({{ $comment->created_at }})</p>
                                        <p>{{ $comment->comment_text }}</p>
                                    </div>
                                </div>
                                <hr />
                            @empty
                                <div class="row">
                                    <div class="col">
                                        <p>There are no comments.</p>
                                    </div>
                                </div>
                                <hr />
                            @endforelse
                            <form action="{{ route('admin.tickets.storeComment', $ticket->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="comment_text">Leave a comment</label>
                                    <textarea class="form-control" id="comment_text" name="comment_text" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">@lang('global.submit')</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.analyses') }}
                        </th>
                        <td>
                            @forelse ($ticket->analyses as $analyse)
                                <div class="row">
                                    <div class="col">
                                        <p class="font-weight-bold"><a href="mailto:{{ $analyse->author_email }}">{{ $analyse->author_name }}</a> ({{ $analyse->created_at }})</p>
                                        <p>{{ $analyse->analyse_text }}</p>
                                    </div>
                                </div>
                                <hr />
                            @empty
                                <div class="row">
                                    <div class="col">
                                        <p>There are no analyses.</p>
                                    </div>
                                </div>
                                <hr />
                            @endforelse
                            <form action="{{ route('admin.tickets.storeAnalyse', $ticket->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="analyse_text">Leave an analyse</label>
                                    <textarea class="form-control" id="analyse_text" name="analyse_text" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">@lang('global.submit')</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ticket.fields.details') }}
                        </th>
                        <td>
                            @forelse ($ticket->details as $detail)
                                <div class="row">
                                    <div class="col">
                                        <p class="font-weight-bold"><a href="mailto:{{ $detail->author_email }}">{{ $detail->author_name }}</a> ({{ $detail->created_at }})</p>
                                        <p>{{ $detail->detail_text }}</p>
                                    </div>
                                </div>
                                <hr />
                            @empty
                                <div class="row">
                                    <div class="col">
                                        <p>There are no details.</p>
                                    </div>
                                </div>
                                <hr />
                            @endforelse
                            <form action="{{ route('admin.tickets.storeDetail', $ticket->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="detail_text">Leave a detail</label>
                                    <textarea class="form-control" id="detail_text" name="detail_text" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">@lang('global.submit')</button>
                            </form>
                        </td>
                    </tr>
                    @if($ticket->category->name == 'Incident')
                        <tr>
                            <th>
                                {{ trans('cruds.ticket.fields.root_causes') }}
                            </th>
                            <td>
                                @forelse ($ticket->root_causes as $root_cause)
                                    <div class="row">
                                        <div class="col">
                                            <p class="font-weight-bold"><a href="mailto:{{ $root_cause->author_email }}">{{ $root_cause->author_name }}</a> ({{ $root_cause->created_at }})</p>
                                            <p>{{ $root_cause->root_cause_text }}</p>
                                        </div>
                                    </div>
                                    <hr />
                                @empty
                                    <div class="row">
                                        <div class="col">
                                            <p>There are no root causes.</p>
                                        </div>
                                    </div>
                                    <hr />
                                @endforelse
                                <form action="{{ route('admin.tickets.storeRootCause', $ticket->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="root_cause_text">Leave a root cause</label>
                                        <textarea class="form-control" id="root_cause_text" name="root_cause_text" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">@lang('global.submit')</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.ticket.fields.resolutions') }}
                            </th>
                            <td>
                                @forelse ($ticket->resolutions as $resolution)
                                    <div class="row">
                                        <div class="col">
                                            <p class="font-weight-bold"><a href="mailto:{{ $resolution->author_email }}">{{ $resolution->author_name }}</a> ({{ $resolution->created_at }})</p>
                                            <p>{{ $resolution->resolution_text }}</p>
                                        </div>
                                    </div>
                                    <hr />
                                @empty
                                    <div class="row">
                                        <div class="col">
                                            <p>There are no resolutions.</p>
                                        </div>
                                    </div>
                                    <hr />
                                @endforelse
                                <form action="{{ route('admin.tickets.storeResolution', $ticket->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="resolution_text">Leave a resolution</label>
                                        <textarea class="form-control" id="resolution_text" name="resolution_text" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">@lang('global.submit')</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <a class="btn btn-default my-2" href="{{ route('admin.tickets.index') }}">
            {{ trans('global.back_to_list') }}
        </a>

        <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-primary">
            @lang('global.edit') @lang('cruds.ticket.title_singular')
        </a>

        <nav class="mb-3">
            <div class="nav nav-tabs">

            </div>
        </nav>
    </div>
</div>
@endsection