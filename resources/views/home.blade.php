@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    Ticket status
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <div class="col">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-3">
                                    <div class="text-value">{{ number_format($totalTickets) }}</div>
                                    <div>Total tickets</div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-white bg-danger">
                                <div class="card-body pb-3">
                                    <div class="text-value">{{ number_format($openTickets) }}</div>
                                        <div>Open tickets</div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-white bg-warning">
                                <div class="card-body pb-3">
                                    <div class="text-value">{{ number_format($pendingTicket) }}</div>
                                    <div>Pending tickets</div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-white bg-success">
                                <div class="card-body pb-3">
                                    <div class="text-value">{{ number_format($closedTickets) }}</div>
                                        <div>Closed tickets</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    Ticket status
                </div>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            
            <div class="card">
                <div class="card-header">
                    Last Tickets
                </div>
                <div class="card-body">
                    <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Ticket">
                        <thead>
                            <tr>
                                <th>
                                    
                                </th>
                                <th>
                                    {{ trans('cruds.ticket.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.ticket.fields.title') }}
                                </th>
                                <th>
                                    {{ trans('cruds.ticket.fields.status') }}
                                </th>
                                <th>
                                    {{ trans('cruds.ticket.fields.priority') }}
                                </th>
                                <th>
                                    {{ trans('cruds.ticket.fields.category') }}
                                </th>
                                <th>
                                    {{ trans('cruds.ticket.fields.author_name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.ticket.fields.author_email') }}
                                </th>
                                <th>
                                    {{ trans('cruds.ticket.fields.assigned_to_user') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
let filters = `
<form class="form-inline" id="filtersForm">
  <div class="form-group mx-sm-3 mb-2">
    <select class="form-control" name="status">
      <option value="">All statuses</option>
      @foreach($statuses as $status)
        <option value="{{ $status->id }}"{{ request('status') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group mx-sm-3 mb-2">
    <select class="form-control" name="priority">
      <option value="">All priorities</option>
      @foreach($priorities as $priority)
        <option value="{{ $priority->id }}"{{ request('priority') == $priority->id ? 'selected' : '' }}>{{ $priority->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group mx-sm-3 mb-2">
    <select class="form-control" name="category">
      <option value="">All categories</option>
      @foreach($categories as $category)
        <option value="{{ $category->id }}"{{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
      @endforeach
    </select>
  </div>
</form>`;
$('.card-body').on('change', 'select', function() {
  $('#filtersForm').submit();
})
  let dtButtons = []
  let searchParams = new URLSearchParams(window.location.search)
  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: {
      url: "{{ route('admin.tickets.index') }}",
      data: {
        'status': searchParams.get('status'),
        'priority': searchParams.get('priority'),
        'category': searchParams.get('category')
      }
    },
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{
    data: 'title',
    name: 'title', 
    render: function ( data, type, row) {
        return '<a href="'+row.view_link+'">'+data+' ('+row.comments_count+')</a>';
    }
},
{ 
  data: 'status_name', 
  name: 'status.name', 
  render: function ( data, type, row) {
      return '<span style="color:'+row.status_color+'">'+data+'</span>';
  }
},
{ 
  data: 'priority_name', 
  name: 'priority.name', 
  render: function ( data, type, row) {
      return '<span style="color:'+row.priority_color+'">'+data+'</span>';
  }
},
{ 
  data: 'category_name', 
  name: 'category.name', 
  render: function ( data, type, row) {
      return '<span style="color:'+row.category_color+'">'+data+'</span>';
  } 
},
{ data: 'author_name', name: 'author_name' },
{ data: 'author_email', name: 'author_email' },
{ data: 'assigned_to_user_name', name: 'assigned_to_user.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };    
$(".datatable-Ticket").one("preInit.dt", function () {
 $(".dataTables_filter").after(filters);
});
  $('.datatable-Ticket').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

</script>
@endsection