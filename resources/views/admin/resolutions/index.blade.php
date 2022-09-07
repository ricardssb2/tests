@extends('layouts.admin')
@section('content')
@can('resolution_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.resolutions.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.resolution.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.resolution.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Comment">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.resolution.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.resolution.fields.ticket') }}
                        </th>
                        <th>
                            {{ trans('cruds.resolution.fields.author_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.resolution.fields.author_email') }}
                        </th>
                        <th>
                            {{ trans('cruds.resolution.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.resolution.fields.resolution_text') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resolutions as $key => $resolution)
                        <tr data-entry-id="{{ $resolution->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $resolution->id ?? '' }}
                            </td>
                            <td>
                                {{ $resolution->ticket->title ?? '' }}
                            </td>
                            <td>
                                {{ $resolution->author_name ?? '' }}
                            </td>
                            <td>
                                {{ $resolution->author_email ?? '' }}
                            </td>
                            <td>
                                {{ $resolution->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $resolution->resolution_text ?? '' }}
                            </td>
                            <td>
                                @can('resolution_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.resolutions.show', $resolution->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('resolution_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.resolutions.edit', $resolution->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('resolution_delete')
                                    <form action="{{ route('admin.resolutions.destroy', $resolution->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('resolution_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.resolutions.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Comment:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection