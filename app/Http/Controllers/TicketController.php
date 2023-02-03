<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Notifications\CommentEmailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use MediaUploadingTrait;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'content'       => 'required',
            'author_name'   => 'required',
            'author_email'  => 'required|email',
        ]);

        $request->request->add([
            'category_id'   => 1,
            'status_id'     => 1,
            'priority_id'   => 1
        ]);

        $ticket = Ticket::create($request->all());

        foreach ($request->input('attachments', []) as $file) {
            $ticket->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('attachments');
        }

        return redirect()->back()->withStatus('Your ticket has been submitted, we will be in touch. You can view ticket status <a href="'.route('tickets.show', $ticket->id).'">here</a>');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('comments');
        $ticket->load('analyses');
        $ticket->load('details');
        $ticket->load('resolutions');
        $ticket->load('root_causes');

        return view('tickets.show', compact('ticket'));
    }

    public function storeComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'comment_text' => 'required'
        ]);

        $comment = $ticket->comments()->create([
            'author_name'   => $ticket->author_name,
            'author_email'  => $ticket->author_email,
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

        $analyse = $ticket->analyses()->create([
            'author_name'   => $ticket->author_name,
            'author_email'  => $ticket->author_email,
            'analyse_text'  => $request->analyse_text
        ]);
        
        $ticket->sendAnalyseNotification($comment);

        return redirect()->back()->withStatus('Your analyse added successfully');
    }

    public function storeDetail(Request $request, Ticket $ticket)
    {
        $request->validate([
            'detail_text' => 'required'
        ]);

        $detail = $ticket->details()->create([
            'author_name'   => $ticket->author_name,
            'author_email'  => $ticket->author_email,
            'detail_text'  => $request->detail_text
        ]);

        $ticket->sendDetailNotification($comment);

        return redirect()->back()->withStatus('Your detail added successfully');
    }
    
    public function storeResolution(Request $request, Ticket $ticket)
    {
        $request->validate([
            'resolution_text' => 'required'
        ]);

        $resolution = $ticket->resolutions()->create([
            'author_name'   => $ticket->author_name,
            'author_email'  => $ticket->author_email,
            'resolution_text'  => $request->resolution_text
        ]);

        $ticket->sendResolutionNotification($comment);

        return redirect()->back()->withStatus('Your resolution added successfully');
    }

    public function storeRootCause(Request $request, Ticket $ticket)
    {
        $request->validate([
            'root_cause_text' => 'required'
        ]);

        $root_cause = $ticket->root_causes()->create([
            'author_name'   => $ticket->author_name,
            'author_email'  => $ticket->author_email,
            'root_cause_text'  => $request->root_cause_text
        ]);

        $ticket->sendRootCauseNotification($comment);

        return redirect()->back()->withStatus('Your root cause added successfully');
    }
}
