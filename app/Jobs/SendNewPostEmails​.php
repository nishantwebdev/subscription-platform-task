<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPostEmail;
use App\Providers\NotificationHistory;

class SendNewPostEmails​ implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $website = null;
    private $post = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post, $website)
    {
        $this->website = $website;
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscribers = $this->website->usersSubscribed;
        foreach ($subscribers as $subscriber) {
            $data['website_name'] = $this->website->name;
            $data['title'] = $this->post->title;
            $data['description'] = $this->post->description;
            Mail::to($subscriber->email)->send(new NewPostEmail($data));
            event(new NotificationHistory($data['title'], $data['website_name'], $subscriber->email));
        }
    }
}
