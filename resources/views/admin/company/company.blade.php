@extends('layouts.admin')
@section('content')
<!-- Button trigger modal -->
<button type="button" class="btn btn-success" style="margin-bottom:30px;"  data-bs-toggle="modal" data-bs-target="#addCompanyModal">
  Add Company
</button>

<div class="card">
  <div class="card-header">
    Company List
  </div>
  <div class="card-body">
    <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Company Name</th>
      <th>Company CEO</th>
      <th>Phone Number</th>
      <th>Actions</th> <!-- new column for delete button -->
    </tr>
  </thead>
  <tbody>
    @foreach($companies as $company)
    <tr>
      <td>{{ $company->id }}</td>
      <td>{{ $company->name }}</td>
      <td>{{ $company->owner }}</td>
      <td>{{ $company->phone_number }}</td>
      <td>
        <form action="{{ route('company.destroy', $company->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
  </table>
</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCompanyModalLabel">Add Company</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form to add a new company -->
        <form method="POST" action="{{ route('company.store') }}">
            @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="owner">Company CEO</label>
                    <input type="text" class="form-control" id="owner" name="owner" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
    </div>
    <button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
</form>
      </div>
    </div>
  </div>
</div>
@endsection