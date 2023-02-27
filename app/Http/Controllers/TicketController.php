<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Notifications\CommentEmailNotification;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
    public function store(Request $request) // saving ticket to database
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
        
        $ticket_id = $ticket->id; // gets selected ticket id
        $list = [];
        $data_list = [];
        $total_time_spent = [];
        $ticket_logs = DB::table('audit_logs')->where('subject_id', $ticket_id)->get(); 
        //gets the audit logs for the ticket from database

        foreach ($ticket_logs as $ticket_log) 
        { //goes through each item of the audit logs

            $properties = json_decode($ticket_log->properties);
            // converts properties values to a list
            $ticket_log->properties = $properties;
            // updates the properties to be a list     
        };
        
        for($i = 0; $i < count($ticket_logs); $i++)
        {
                    // array_push($data_list, $ticket_logs[$i]->properties->status_id);
                    array_push($data_list, $ticket_logs[$i]->properties->status_id);
                    array_push($list, date('Y-m-d H:i:s', strtotime($ticket_logs[$i]->properties->updated_at))
                );
        }

        // dd($ticket_logs, $list, $data_list);
        $result_list = [];
        for($i = 0; $i < count($data_list); $i++)
        {
            $new_array = [$list[$i]];
                if (isset($data_list[$i]))
                {
                    $new_array[] = $data_list[$i];
                }
            array_push($result_list, $new_array);
            
        }

        $list_of_dates = []; // creating a list of 
        for($i = 0 ; $i < count($result_list) - 1; $i++)
        {
            
            $start_time = $result_list[$i][0];
            $end_time = $result_list[$i + 1][0];

            $start_datetime = new DateTime($start_time);
            $diff = $start_datetime->diff(new DateTime($end_time));

            $start_status = $result_list[$i][1];
            $end_status = $result_list[$i + 1][1];

            echo "<br>Start:".$start_status . " at: " . $start_time .  " <br> End: " . $end_status . " at: " . $end_time;

            if ($start_status != $end_status)
            {
                array_push($list_of_dates, array($diff->s, $diff->i, $diff->h, $diff->d));
                echo "<br>" . $diff->d.' Days<br>';
                echo $diff->h.' Hours<br>';
                echo $diff->i.' Minutes<br>';
                echo $diff->s.' Seconds<br>';

            }
            
        }

        $seconds = 0;
        $minutes = 0;
        $hours = 0;
        $days = 0;
        for($i = 0; $i < count($list_of_dates); $i++)
        {
            if ($seconds >= 60) 
            {
                $minutes++;
                $seconds -= 60;
            }
            elseif ($minutes >= 60) 
            {
                $hours++;
                $hours -= 60;
            }
            elseif($hours >= 24)
            {
                $days++;
                $hours -= 24;
            }
            $seconds += $list_of_dates[$i][0];
            $minutes += $list_of_dates[$i][1];
            $hours += $list_of_dates[$i][2];
            $days += $list_of_dates[$i][3];


        }
        
        // while ($seconds >= 60) 
        // {
        //     $minutes++;
        //     $seconds -= 60;
        // }
        // while ($minutes >= 60) 
        // {
        //     $hours++;
        //     $hours -= 60;
        // }
        // while($hours >= 24)
        // {
        //     $days++;
        //     $hours -= 24;
        // }
        echo $seconds . " seconds " . $minutes . " minutes " . $hours . " hours ". $days . " days <br>";         
        
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

