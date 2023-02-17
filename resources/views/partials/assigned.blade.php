@if(auth()->user()->isAdmin())
<div class="form-group {{ $errors->has('assigned_to_user_id') ? 'has-error' : '' }}">
    <select name="assigned_to_user_id" id="assigned_to_user" class="form-control select2">
        <option selected="true">None</option>    
        @foreach($assigned_to_users as $id => $assigned_to_user)
            <option value="{{ $id }}" {{ (isset($ticket) && $ticket->assigned_to_user ? $ticket->assigned_to_user->id : old('assigned_to_user_id')) == $id ? 'selected' : '' }}>{{ $assigned_to_user }}</option>
        @endforeach
    </select>
    @if($errors->has('assigned_to_user_id'))
        <em class="invalid-feedback">
            {{ $errors->first('assigned_to_user_id') }}
        </em>
    @endif
</div>
@endif

<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script>

$( "#assigned_to_user" ).change(function() {
    var selectedUser = $('#assigned_to_user').val();

        $.ajax({
            type: 'GET',
            data: {
                selectedUser: selectedUser
            },
            url: "{{url('admin/assign_user')}}",
        });
});

</script>