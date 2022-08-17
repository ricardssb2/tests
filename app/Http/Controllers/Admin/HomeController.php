<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Ticket;
use App\Category;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Priority;
use App\Status;
use App\User;
use Illuminate\Http\Request;

class HomeController
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('dashboard_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $totalTickets = Ticket::count();
        $openTickets = Ticket::whereHas('status', function($query) {
            $query->whereName('Open');
        })->count();
        $pendingTicket = Ticket::whereHas('status', function($query) {
            $query->whereName('Pending');
        })->count();
        $closedTickets = Ticket::whereHas('status', function($query) {
            $query->whereName('Closed');
        })->count();

        
        $user = auth()->user();
        $id = $user->id;
        $email = $user->email;
        $currentUser = User::find($id);

        if ($request->ajax()) {
            // if admin, show all tickets, else show only tickets assigned to user
            if ($currentUser->isAgentOrAdmin()) {
                $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])->select(sprintf('%s.*', (new Ticket)->table));
            } else {
                $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])->select(sprintf('%s.*', (new Ticket)->table))->where('tickets.author_email', $email);
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'ticket_show';
                $editGate      = 'ticket_edit';
                $crudRoutePart = 'tickets';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });
            $table->addColumn('status_color', function ($row) {
                return $row->status ? $row->status->color : '#000000';
            });

            $table->addColumn('priority_name', function ($row) {
                return $row->priority ? $row->priority->name : '';
            });
            $table->addColumn('priority_color', function ($row) {
                return $row->priority ? $row->priority->color : '#000000';
            });

            $table->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : '';
            });
            $table->addColumn('category_color', function ($row) {
                return $row->category ? $row->category->color : '#000000';
            });

            $table->editColumn('author_name', function ($row) {
                return $row->author_name ? $row->author_name : "";
            });
            $table->editColumn('author_email', function ($row) {
                return $row->author_email ? $row->author_email : "";
            });
            $table->addColumn('assigned_to_user_name', function ($row) {
                return $row->assigned_to_user ? $row->assigned_to_user->name : '';
            });

            $table->addColumn('comments_count', function ($row) {
                return $row->comments->count();
            });

            $table->addColumn('view_link', function ($row) {
                return route('admin.tickets.show', $row->id);
            });

            $table->rawColumns(['actions', 'placeholder', 'status', 'priority', 'category', 'assigned_to_user']);

            return $table->make(true);
        }
        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();


        return view('home', compact('totalTickets', 'openTickets', 'pendingTicket', 'closedTickets', 'priorities', 'statuses', 'categories', 'currentUser'));
    }
}
