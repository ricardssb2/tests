@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.resolution.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.resolutions.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('ticket_id') ? 'has-error' : '' }}">
                <label for="ticket">{{ trans('cruds.resolution.fields.ticket') }}</label>
                <select name="ticket_id" id="ticket" class="form-control select2">
                    @foreach($tickets as $id => $ticket)
                        <option value="{{ $id }}" {{ (isset($resolution) && $resolution->ticket ? $resolution->ticket->id : old('ticket_id')) == $id ? 'selected' : '' }}>{{ $ticket }}</option>
                    @endforeach
                </select>
                @if($errors->has('ticket_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('ticket_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('author_name') ? 'has-error' : '' }}">
                <label for="author_name">{{ trans('cruds.resolution.fields.author_name') }}*</label>
                <input type="text" id="author_name" name="author_name" class="form-control" value="{{ old('author_name', isset($resolution) ? $resolution->author_name : '') }}" required>
                @if($errors->has('author_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('author_name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.resolution.fields.author_name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('author_email') ? 'has-error' : '' }}">
                <label for="author_email">{{ trans('cruds.resolution.fields.author_email') }}*</label>
                <input type="text" id="author_email" name="author_email" class="form-control" value="{{ old('author_email', isset($resolution) ? $resolution->author_email : '') }}" required>
                @if($errors->has('author_email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('author_email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.resolution.fields.author_email_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                <label for="user">{{ trans('cruds.resolution.fields.user') }}</label>
                <select name="user_id" id="user" class="form-control select2">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (isset($resolution) && $resolution->user ? $resolution->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('resolution_text') ? 'has-error' : '' }}">
                <label for="resolution_text">{{ trans('cruds.resolution.fields.resolution_text') }}*</label>
                <textarea id="resolution_text" name="resolution_text" class="form-control " required>{{ old('resolution_text', isset($resolution) ? $resolution->resolution_text : '') }}</textarea>
                @if($errors->has('resolution_text'))
                    <em class="invalid-feedback">
                        {{ $errors->first('resolution_text') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.resolution.fields.resolution_text_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection