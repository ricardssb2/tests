<?php

namespace App;

use App\Scopes\AgentScope;
use App\Traits\Auditable;
use App\Notifications\CommentEmailNotification;
use App\Notifications\AnalyseEmailNotification;
use App\Notifications\DetailEmailNotification;
use App\Notifications\ResolutionEmailNotification;
use App\Notifications\RootCauseEmailNotification;
use App\Notifications\TicketUpdateNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Ticket extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable;

    public $table = 'tickets';

    protected $appends = [
        'attachments',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'content',
        'status_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'priority_id',
        'category_id',
        'author_name',
        'author_email',
        'assigned_to_user_id',
    ];

    public static function boot()
    {
        parent::boot();

        Ticket::observe(new \App\Observers\TicketActionObserver);

        // Uncomment to make agents see only their assigned tickets
        //static::addGlobalScope(new AgentScope);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id', 'id');
    }

    public function analyses()
    {
        return $this->hasMany(Analyse::class, 'ticket_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(Detail::class, 'ticket_id', 'id');
    }

    public function resolutions()
    {
        return $this->hasMany(Resolution::class, 'ticket_id', 'id');
    }

    public function root_causes()
    {
        return $this->hasMany(Root_Cause::class, 'ticket_id', 'id');
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function assigned_to_user()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function scopeFilterTicket($query)
    {
        $query->when(request()->input('priority'), function($query) {
                $query->whereHas('priority', function($query) {
                    $query->whereId(request()->input('priority'));
                });
            })
            ->when(request()->input('category'), function($query) {
                $query->whereHas('category', function($query) {
                    $query->whereId(request()->input('category'));
                });
            })
            ->when(request()->input('status'), function($query) {
                $query->whereHas('status', function($query) {
                    $query->whereId(request()->input('status'));
                });
            });
    }

    /* if you uncomment this, you need to put static at the upper function 
    public function scopeFilterTickets($query) {
        Ticket::scopeFilterTicket($query);
    }*/

    public function sendCommentNotification($comment)
    {
        $users = \App\User::where(function ($q) {
                $q->whereHas('roles', function ($q) {
                    return $q->where('title', 'Agent');
                })
                ->where(function ($q) {
                    $q->whereHas('comments', function ($q) {
                        return $q->whereTicketId($this->id);
                    })
                    ->orWhereHas('tickets', function ($q) {
                        return $q->whereId($this->id);
                    }); 
                });
            })
            ->when(!$comment->user_id && !$this->assigned_to_user_id, function ($q) {
                $q->orWhereHas('roles', function ($q) {
                    return $q->where('title', 'Admin');
                });
            })
            ->when($comment->user, function ($q) use ($comment) {
                $q->where('id', '!=', $comment->user_id);
            })
            ->get();
        $usersadmin = \App\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        $notification = new CommentEmailNotification($comment);

        Notification::send($users, $notification);
        Notification::send($usersadmin, $notification);
        if($comment->user_id && $this->author_email)
        {
            Notification::route('mail', $this->author_email)->notify($notification);
        }
    }

    public function sendAnalyseNotification($analyse)
    {
        $users = \App\User::where(function ($q) {
                $q->whereHas('roles', function ($q) {
                    return $q->where('title', 'Agent');
                })
                ->where(function ($q) {
                    $q->whereHas('analyses', function ($q) {
                        return $q->whereTicketId($this->id);
                    })
                    ->orWhereHas('tickets', function ($q) {
                        return $q->whereId($this->id);
                    }); 
                });
            })
            ->when(!$analyse->user_id && !$this->assigned_to_user_id, function ($q) {
                $q->orWhereHas('roles', function ($q) {
                    return $q->where('title', 'Admin');
                });
            })
            ->when($analyse->user, function ($q) use ($analyse) {
                $q->where('id', '!=', $analyse->user_id);
            })
            ->get();
        $usersadmin = \App\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        $notification = new AnalyseEmailNotification($analyse);

        Notification::send($users, $notification);
        Notification::send($usersadmin, $notification);
        if($analyse->user_id && $this->author_email)
        {
            Notification::route('mail', $this->author_email)->notify($notification);
        }
    }

    public function sendDetailNotification($detail)
    {
        $users = \App\User::where(function ($q) {
                $q->whereHas('roles', function ($q) {
                    return $q->where('title', 'Agent');
                })
                ->where(function ($q) {
                    $q->whereHas('details', function ($q) {
                        return $q->whereTicketId($this->id);
                    })
                    ->orWhereHas('tickets', function ($q) {
                        return $q->whereId($this->id);
                    }); 
                });
            })
            ->when(!$detail->user_id && !$this->assigned_to_user_id, function ($q) {
                $q->orWhereHas('roles', function ($q) {
                    return $q->where('title', 'Admin');
                });
            })
            ->when($detail->user, function ($q) use ($detail) {
                $q->where('id', '!=', $detail->user_id);
            })
            ->get();
        $usersadmin = \App\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        $notification = new DetailEmailNotification($detail);

        Notification::send($users, $notification);
        Notification::send($usersadmin, $notification);
        if($detail->user_id && $this->author_email)
        {
            Notification::route('mail', $this->author_email)->notify($notification);
        }
    }

    public function sendResolutionNotification($resolution)
    {
        $users = \App\User::where(function ($q) {
                $q->whereHas('roles', function ($q) {
                    return $q->where('title', 'Agent');
                })
                ->where(function ($q) {
                    $q->whereHas('resolutions', function ($q) {
                        return $q->whereTicketId($this->id);
                    })
                    ->orWhereHas('tickets', function ($q) {
                        return $q->whereId($this->id);
                    }); 
                });
            })
            ->when(!$resolution->user_id && !$this->assigned_to_user_id, function ($q) {
                $q->orWhereHas('roles', function ($q) {
                    return $q->where('title', 'Admin');
                });
            })
            ->when($resolution->user, function ($q) use ($resolution) {
                $q->where('id', '!=', $resolution->user_id);
            })
            ->get();
        $usersadmin = \App\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        $notification = new ResolutionEmailNotification($resolution);

        Notification::send($users, $notification);
        Notification::send($usersadmin, $notification);
        if($resolution->user_id && $this->author_email)
        {
            Notification::route('mail', $this->author_email)->notify($notification);
        }
    }

    public function sendRootCauseNotification($root_cause)
    {
        $users = \App\User::where(function ($q) {
                $q->whereHas('roles', function ($q) {
                    return $q->where('title', 'Agent');
                })
                ->where(function ($q) {
                    $q->whereHas('root_causes', function ($q) {
                        return $q->whereTicketId($this->id);
                    })
                    ->orWhereHas('tickets', function ($q) {
                        return $q->whereId($this->id);
                    }); 
                });
            })
            ->when(!$root_cause->user_id && !$this->assigned_to_user_id, function ($q) {
                $q->orWhereHas('roles', function ($q) {
                    return $q->where('title', 'Admin');
                });
            })
            ->when($root_cause->user, function ($q) use ($root_cause) {
                $q->where('id', '!=', $root_cause->user_id);
            })
            ->get();
        $usersadmin = \App\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        $notification = new RootCauseEmailNotification($root_cause);

        Notification::send($users, $notification);
        Notification::send($usersadmin, $notification);
        if($root_cause->user_id && $this->author_email)
        {
            Notification::route('mail', $this->author_email)->notify($notification);
        }
    }

    public function sendUpdateNotification($ticket ,$table)
    {
        $user = \App\User::where('email', $this->author_email)->first();
        $usersadmin = \App\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        $notification = new TicketUpdateNotification($ticket, $table);

        Notification::send($user, $notification);
        Notification::send($usersadmin, $notification);
        if($ticket->user_id && $this->author_email)
        {
            Notification::route('mail', $this->author_email)->notify($notification);
        }
    }
}
