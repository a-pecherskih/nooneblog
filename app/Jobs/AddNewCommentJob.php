<?php

namespace App\Jobs;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddNewCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    public $commentData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $commentData)
    {
        $this->commentData = $commentData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(3);

        Comment::query()->create([
            'created_at' => Carbon::now(),
            'subject' => $this->commentData['subject'],
            'body' => $this->commentData['body'],
            'article_id' => $this->commentData['article_id'],
        ]);
    }
}
