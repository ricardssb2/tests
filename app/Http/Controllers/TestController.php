<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
 
use App\User;

use Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
class TestController extends Controller
{
    
    public function index(Request $request)
    {
        $user = User::all();

        if ($request->ajax()) {
            return datatables()->of($user)
                ->addColumn('action', function ($row) {
                    $html = '<a href="/admin/user/' . $row->id .'" class="btn btn-xs btn-primary">View</a> ';
                    $html .= '<a href="/admin/users/' . $row->id .'/edit" class="btn btn-xs btn-info">Edit</a> ';
                    $html .= '<button data-rowid="' . $row->id . '" class="btn btn-xs btn-danger btn-delete">Delete</button>';
                    return $html;
                })->toJson();
        }

        return view('admin.test.index');
    }

    public function store(Request $request)
    {
        // do validation
        User::create($request->all());
        return ['success' => true, 'message' => 'Inserted Successfully'];
    }

    public function show($id)
    {
        return;
    }

    public function update($id)
    {
        // do validation
        User::find($id)->update(request()->all());
        return ['success' => true, 'message' => 'Updated Successfully'];
    }

    public function destroy($id)
    {

        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $current_user = json_encode(Auth::user()->email); //fetches currently logged in user data and converts it to json string
        $user = User::find($id);

        if($current_user != json_encode($user->email)) //compares currently logged in user with the user that would be deleted
        { // if emails do not match, user is deleted
            User::find($id)->delete(); 
            return true;
        }
        else //if emails match, deletion is prevented
        {
            return false;
        }

    }
}