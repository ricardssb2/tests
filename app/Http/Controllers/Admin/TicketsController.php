<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Priority;
use App\Status;
use App\Ticket;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TicketsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $email = $user->email;
        $currentUser = User::find($id);

        if ($request->ajax()) {
            // if admin, show all tickets, else show only tickets assigned to user
            if ($currentUser->isAgentOrAdmin()) {
                $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments', 'analyses'])->select(sprintf('%s.*', (new Ticket)->table));
            } else {
                $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments', 'analyses'])->select(sprintf('%s.*', (new Ticket)->table))->where('tickets.author_email', $email);
            }
            //$query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])
            //    ->filterTickets($request)
            //    ->filterTickets(array_merge($request, ['email' => $currentUser->email]))
            //    ->select(sprintf('%s.*', (new Ticket)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'ticket_show';
                $editGate      = 'ticket_edit';
                $deleteGate    = 'ticket_delete';
                $crudRoutePart = 'tickets';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
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

            $table->addColumn('analyses_count', function ($row) {
                return $row->analyses->count();
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

        return view('admin.tickets.index', compact('priorities', 'statuses', 'categories', 'currentUser'));
    }

    public function create()
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = Status::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $priorities = Priority::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assigned_to_users = User::whereHas('roles', function($query) {
                $query->whereId(2);
            })
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('admin.tickets.create', compact('statuses', 'priorities', 'categories', 'assigned_to_users'));
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->all());

        foreach ($request->input('attachments', []) as $file) {
            $ticket->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('attachments');
        }

        return redirect()->route('admin.tickets.index');
    }

    public function edit(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = Status::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $priorities = Priority::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assigned_to_users = User::whereHas('roles', function($query) {
                $query->whereId(2);
            })
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $ticket->load('status', 'priority', 'category', 'assigned_to_user');

        return view('admin.tickets.edit', compact('statuses', 'priorities', 'categories', 'assigned_to_users', 'ticket'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->all());
        $changes = $ticket->getChanges();

        foreach($changes as $key => $value) {
            if($key == 'status_id') {
                $key = 'Status';
                $changes = array_replace($changes, array($key => Status::find($value)->name));
                unset($changes['status_id']);
            }
            if($key == 'priority_id') {
                $key = 'Priority';
                $changes = array_replace($changes, array($key => Priority::find($value)->name));
                unset($changes['priority_id']);
            }
            if($key == 'category_id') {
                $key = 'Category';
                $changes = array_replace($changes, array($key => Category::find($value)->name));
                unset($changes['category_id']);
            }
        }

        if (count($ticket->attachments) > 0) {
            foreach ($ticket->attachments as $media) {
                if (!in_array($media->file_name, $request->input('attachments', []))) {
                    $media->delete();
                }
            }
        }

        $media = $ticket->attachments->pluck('file_name')->toArray();

        foreach ($request->input('attachments', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $ticket->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('attachments');
            }
        }
        //delete updated_at from changes
        unset($changes['updated_at']);
        $ticket->sendUpdateNotification($ticket, $changes);

        return redirect()->route('admin.tickets.index');
    }

    public function show(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->load('status', 'priority', 'category', 'assigned_to_user', 'comments','analyses');

        return view('admin.tickets.show', compact('ticket'));
    }

    public function destroy(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->delete();

        return back();
    }

    public function massDestroy(MassDestroyTicketRequest $request)
    {
        Ticket::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'comment_text' => 'required'
        ]);
        $user = auth()->user();
        $comment = $ticket->comments()->create([
            'author_name'   => $user->name,
            'author_email'  => $user->email,
            'user_id'       => $user->id,
            'comment_text'  => $request->comment_text
        ]);

        $ticket->sendCommentNotification($comment);

        return redirect()->back()->withStatus('Your comment added successfully');
    }

    public function storeAnalyse(Request $request, Ticket $ticket)
    {
        $request->validate([
            'analyse_text' => 'required'
        ]);
        $user = auth()->user();
        $analyse = $ticket->analyses()->create([
            'author_name'   => $user->name,
            'author_email'  => $user->email,
            'user_id'       => $user->id,
            'analyse_text'  => $request->analyse_text
        ]);

        $ticket->sendAnalyseNotification($analyse);

        return redirect()->back()->withStatus('Your analyse added successfully');
    }
    
    public function storeDetail(Request $request, Ticket $ticket)
    {
        $request->validate([
            'detail_text' => 'required'
        ]);
        $user = auth()->user();
        $detail = $ticket->details()->create([
            'author_name'   => $user->name,
            'author_email'  => $user->email,
            'user_id'       => $user->id,
            'detail_text'  => $request->detail_text
        ]);

        $ticket->sendDetailNotification($analyse);

        return redirect()->back()->withStatus('Your detail added successfully');
    }

    public function storeResolution(Request $request, Ticket $ticket)
    {
        $request->validate([
            'resolution_text' => 'required'
        ]);
        $user = auth()->user();
        $resolution = $ticket->resolutions()->create([
            'author_name'   => $user->name,
            'author_email'  => $user->email,
            'user_id'       => $user->id,
            'resolution_text'  => $request->resolution_text
        ]);

        $ticket->sendResolutionNotification($analyse);

        return redirect()->back()->withStatus('Your resolution added successfully');
    }

    public function storeRootCause(Request $request, Ticket $ticket)
    {
        $request->validate([
            'root_cause_text' => 'required'
        ]);
        $user = auth()->user();
        $root_cause = $ticket->root_causes()->create([
            'author_name'   => $user->name,
            'author_email'  => $user->email,
            'user_id'       => $user->id,
            'root_cause_text'  => $request->root_cause_text
        ]);

        $ticket->sendRooCauseNotification($analyse);

        return redirect()->back()->withStatus('Your root cause added successfully');
    }

    public function openticket(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $email = $user->email;
        $currentUser = User::find($id);

        if ($request->ajax()) {
            // if admin, show all tickets, else show only tickets assigned to user
            if ($currentUser->isAgentOrAdmin()) {
                $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])->select(sprintf('%s.*', (new Ticket)->table))->where('status_id', '=', 1);
            } else {
                $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])->select(sprintf('%s.*', (new Ticket)->table))->where('tickets.author_email', $email)->where('status_id', '=', 1);
            }
            //$query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])
            //    ->filterTickets($request)
            //    ->filterTickets(array_merge($request, ['email' => $currentUser->email]))
            //    ->select(sprintf('%s.*', (new Ticket)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'ticket_show';
                $editGate      = 'ticket_edit';
                $deleteGate    = 'ticket_delete';
                $crudRoutePart = 'tickets';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
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

        return view('admin.tickets.list', compact('priorities', 'statuses', 'categories', 'currentUser'));
    }

    public function pendingticket(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $email = $user->email;
        $currentUser = User::find($id);

        if ($request->ajax()) {
            // if admin, show all tickets, else show only tickets assigned to user
            if ($currentUser->isAgentOrAdmin()) {
                $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])->select(sprintf('%s.*', (new Ticket)->table))->where('status_id', '=', 2);
            } else {
                $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])->select(sprintf('%s.*', (new Ticket)->table))->where('tickets.author_email', $email)->where('status_id', '=', 2);
            }
            //$query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])
            //    ->filterTickets($request)
            //    ->filterTickets(array_merge($request, ['email' => $currentUser->email]))
            //    ->select(sprintf('%s.*', (new Ticket)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'ticket_show';
                $editGate      = 'ticket_edit';
                $deleteGate    = 'ticket_delete';
                $crudRoutePart = 'tickets';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
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

        return view('admin.tickets.list', compact('priorities', 'statuses', 'categories', 'currentUser'));
    }

    public function archive(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $email = $user->email;
        $currentUser = User::find($id);

        if ($request->ajax()) {
            // if admin, show all tickets, else show only tickets assigned to user
            if ($currentUser->isAgentOrAdmin()) {
                $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])->select(sprintf('%s.*', (new Ticket)->table))->where('status_id', '=', 3);
            } else {
                $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])->select(sprintf('%s.*', (new Ticket)->table))->where('tickets.author_email', $email)->where('status_id', '=', 3);
            }
            //$query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])
            //    ->filterTickets($request)
            //    ->filterTickets(array_merge($request, ['email' => $currentUser->email]))
            //    ->select(sprintf('%s.*', (new Ticket)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'ticket_show';
                $editGate      = 'ticket_edit';
                $deleteGate    = 'ticket_delete';
                $crudRoutePart = 'tickets';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
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

        return view('admin.tickets.list', compact('priorities', 'statuses', 'categories', 'currentUser'));
    }

    /*
    public function filteredTickets(Request $request) {
        $user = auth()->user();
        $id = $user->id;
        $email = $user->email;
        $currentUser = User::find($id);
        if ($request->ajax()) {
            // if admin, show all tickets, else show only tickets assigned to user
            $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments'])->select(sprintf('%s.*', (new Ticket)->table));
    
            if (!$currentUser->isAgentOrAdmin()) {
                $query->where('tickets.author_email', $email);
            }
    
            Ticket::scopeFilterTicket($query);
            $ticketsList = $query->get();

            return response()->json($ticketsList);
        }
     }*/
}
