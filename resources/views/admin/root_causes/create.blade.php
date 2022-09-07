@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.root_cause.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.root_causes.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('ticket_id') ? 'has-error' : '' }}">
                <label for="ticket">{{ trans('cruds.root_cause.fields.ticket') }}</label>
                <select name="ticket_id" id="ticket" class="form-control select2">
                    @foreach($tickets as $id => $ticket)
                        <option value="{{ $id }}" {{ (isset($root_cause) && $root_cause->ticket ? $root_cause->ticket->id : old('ticket_id')) == $id ? 'selected' : '' }}>{{ $ticket }}</option>
                    @endforeach
                </select>
                @if($errors->has('ticket_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('ticket_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('author_name') ? 'has-error' : '' }}">
                <label for="author_name">{{ trans('cruds.root_cause.fields.author_name') }}*</label>
                <input type="text" id="author_name" name="author_name" class="form-control" value="{{ old('author_name', isset($root_cause) ? $root_cause->author_name : '') }}" required>
                @if($errors->has('author_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('author_name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.root_cause.fields.author_name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('author_email') ? 'has-error' : '' }}">
                <label for="author_email">{{ trans('cruds.root_cause.fields.author_email') }}*</label>
                <input type="text" id="author_email" name="author_email" class="form-control" value="{{ old('author_email', isset($root_cause) ? $root_cause->author_email : '') }}" required>
                @if($errors->has('author_email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('author_email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.root_cause.fields.author_email_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                <label for="user">{{ trans('cruds.root_cause.fields.user') }}</label>
                <select name="user_id" id="user" class="form-control select2">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (isset($root_cause) && $root_cause->user ? $root_cause->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('root_cause_text') ? 'has-error' : '' }}">
                <label for="root_cause_text">{{ trans('cruds.root_cause.fields.root_cause_text') }}*</label>
                <textarea id="root_cause_text" name="root_cause_text" class="form-control " required>{{ old('root_cause_text', isset($root_cause) ? $root_cause->root_cause_text : '') }}</textarea>
                @if($errors->has('root_cause_text'))
                    <em class="invalid-feedback">
                        {{ $errors->first('root_cause_text') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.root_cause.fields.root_cause_text_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection