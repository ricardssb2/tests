@extends('layouts.admin')

@section('content')

<div id="alert_ajax_error" class="alert alert-danger" role="alert" style="display:none">An error occured.</div>
<div id="alert_ajax_success" class="alert alert-success" role="alert" style="display:none">Account deleted.</div>

@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.users.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>

<div class="card-body">

<div>
    <div class="row">
        <div>
            <table id="users" class="table display nowrap" style="width=100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>email</th>
                        <th width="150">Action</th>
                        
                    </tr>
                </thead>

            </table>
            
        </div>
    </div>
</div>
</div>
</div>

<script>
    
    $(document).ready(function() {
        $.noConflict();
        var table = $('#users').DataTable({
                ajax: '',
                serverSide: true,
                processing: true,
                aaSorting:[[0,"desc"]],
                columns: [ // colums for datatable
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'csv'
                ]
            }); 

        function errorFunction(){ // function to display error alert
            $("#alert_ajax_error").show()
            setTimeout(function() {
                $("#alert_ajax_error").hide();
            }, 5000);
        }

        function successFunction(){ // function to display success alert
            $("#alert_ajax_success").show()
            setTimeout(function() {
                $("#alert_ajax_success").hide();
            }, 5000);
        }

        $(document).on('click','.btn-delete',function(){ // on clicking delete button
            $.ajaxSetup
            ({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if(!confirm("Are you sure?")) return; // confirmation window appears

            var rowid = $(this).data('rowid') // gets the user id from the row
            var el = $(this)
            if(!rowid) return; 

            
            $.ajax({ // send an ajax response for user deletion
                type: "POST",
                dataType: 'JSON',
                url: "/users/" + rowid,
                data: {_method: 'delete',},
                success: function (data) 
                {
                    table.row(el.parents('tr'))
                        .remove()
                        .draw(); // draws the ajax table
                    successFunction();
                },
                error: function (jqXHR, textStatus, errorThrown) { errorFunction(); } // calls error function if ajax request fails
             }); //end of ajax
        })
    })
</script>

@endsection