<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AddCommentNotification extends Notification
{
    use Queueable;

    private Post $post;
    /**
     * @var Comment
     */
    private Comment $comment;
    private User $user;

    /**
     * AddFollowNotification constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
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
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'read_at' => null,
            'data'    => [
                'user'    => $this->user,
                'comment' => $this->comment,
            ],
        ]);
    }
}