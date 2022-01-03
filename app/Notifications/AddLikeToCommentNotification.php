<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AddLikeToCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var User
     */
    private User $user;
    /**
     * @var Comment
     */
    private Comment $comment;

    /**
     * AddFollowNotification constructor.
     * @param User $user
     * @param Comment $comment
     */
    public function __construct(User $user, Comment $comment)
    {
        $this->user    = $user;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        $this->onQueue('notification');

        return $notifiable->isNotificationEnabled(self::class) ? ['broadcast', 'database'] : [];
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return new BroadcastMessage([
            'user'    => $this->user,
            'comment' => $this->comment,
            'date'    => now(),
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'read_at' => null,
            'data'    => [
                'user'    => $this->user,
                'comment' => $this->comment,
                'date'    => now(),
            ],
        ]);
    }
}
