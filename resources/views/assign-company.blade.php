@extends('layouts.admin')
@section('content')
<h1 style="font-weight:bold; font-size:30px; margin-bottom:30px;">Assign Users to company.</h1>
<div class="card">
  <div class="card-header">
    Assign User to Company
  </div>
  <div class="card-body">
  <form method="POST" action="{{ route('assign-company') }}">
    @csrf

    <div>
        <label style="font-size:12px; font-weight:bold;"for="user_id">Select A User</label>
        <select class="form-control" name="user_id" id="user_id">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label style="font-size:12px; font-weight:bold;" for="company_id">Select A Company</label>
        <select class="form-control" name="company_id" id="company_id">
            @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
    </div>
    <button style="margin-top:20px;"type="submit" class="btn btn-primary">Assign</button>
</form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    All Users
  </div>
    <table class="table table-striped table-hover ">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Assigned Company</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->company)
                            {{ $user->company->name }}
                        @else
                            Unassigned
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection