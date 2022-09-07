@extends('layouts.admin')
@section('content')
@can('detail_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.details.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.detail.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.detail.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Comment">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.detail.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.detail.fields.ticket') }}
                        </th>
                        <th>
                            {{ trans('cruds.detail.fields.author_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.detail.fields.author_email') }}
                        </th>
                        <th>
                            {{ trans('cruds.detail.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.detail.fields.detail_text') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $key => $detail)
                        <tr data-entry-id="{{ $detail->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $detail->id ?? '' }}
                            </td>
                            <td>
                                {{ $detail->ticket->title ?? '' }}
                            </td>
                            <td>
                                {{ $detail->author_name ?? '' }}
                            </td>
                            <td>
                                {{ $detail->author_email ?? '' }}
                            </td>
                            <td>
                                {{ $detail->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $detail->detail_text ?? '' }}
                            </td>
                            <td>
                                @can('detail_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.details.show', $detail->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('detail_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.details.edit', $detail->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('detail_delete')
                                    <form action="{{ route('admin.details.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('detail_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.details.massDestroy') }}",
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