<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index() // displays user data
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    // denies access if user doesn't have user_access permissions
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function create() 
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        // denies access if user doesn't have user_create permissions

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request) // stores user data on creation
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // denies access if user doesn't have user_edit permissions

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user) // updates user information when editing
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user) // user deletion function in user section
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $current_user = json_encode(Auth::user()->email); //fetches currently logged in user data and converts it to json string

        if($current_user != json_encode($user->email)) //compares currently logged in user with the user that would be deleted
        { // if emails do not match, user is deleted
            $user->delete(); 
            return back();
        }
        else //if emails match, deletion is prevented
        {
            return back();; // returns error page
        }

    }

    public function massDestroy(MassDestroyUserRequest $request) //function for delete selected (multiple users)
    {

        $u_id = User::whereIn('id', request('ids'))->get(); //selected accounts
        $current_user = json_encode(Auth::user()->email); // currently logged in user

        $list = []; // empty list to store selected user emails
        $matching_email_count = 0;

        foreach(json_decode($u_id) as $key => $value) // goes through all selected users
        {
            array_push($list, $value->email); // adds all selected user emails to array
        }

        foreach($list as $value) // goes through email list
        {
            
            if(json_encode($value) == $current_user): // if current user matches with any of the emails in the list

                $matching_email_count ++;

            endif;
        }

        if($matching_email_count > 0) // if there's a matching email:
            {
                return response()->json([ //returns error
                    'message' => 'Cannot delete your own account'
                ], 403);
            }
            else // if current user doesn't match with any of the emails in the list
            {
                User::whereIn('id', request('ids'))->delete(); //deletes selected users
        
                return response(null, Response::HTTP_NO_CONTENT); 
            }

    }
}
