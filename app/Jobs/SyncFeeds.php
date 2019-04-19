<?php

namespace App\Jobs;

use App\FeedReader\Reader;
use App\FeedSyncers\Syncer;
use App\Models\Feed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncFeeds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $feeds;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $feeds)
    {
        $this->feeds = $feeds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->feeds->map(function (Feed $feed) {
            $syncer = new Syncer($feed, Reader::getInstance($feed->link));
            $syncer->sync();
        });
    }
}
