<?php

namespace App\FeedSyncers;

use App\FeedReader\ReaderInterface;
use App\Models\Feed as FeedModel;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class Syncer implements SyncerInterface
{
    private $feedModel;

    private $reader;

    public function __construct(FeedModel $feedModel, ReaderInterface $reader)
    {
        $this->feedModel = $feedModel;
        $this->reader = $reader;
    }

    public function sync(): bool
    {
        try {
            if ($feed = $this->reader->read()) {
                // update feed
                $this->feedModel->title = $feed->getTitle();
                $this->feedModel->last_synced_at = \Carbon\Carbon::now();
                $this->feedModel->description = $feed->getDescription();
                $this->feedModel->last_modified_at = $feed->getLastModified();
                $this->feedModel->save();

                // update items
                foreach ($feed as $item) {
                    $item = Item::updateOrCreate(
                        ['hashed_public_id' => md5($item->getPublicId()), 'feed_id' => $this->feedModel->id],
                        [
                            'title' => $item->getTitle(),
                            'link' => $item->getLink(),
                            'description' => $item->getDescription(),
                            'pub_date' => $item->getLastModified(),
                            'creator' => $item->getAuthor()->getName(),
                            'timestamp' => $item->getLastModified() ? $item->getLastModified()->getTimestamp() : 0,
                        ]
                    );

                    $this->feedModel->items()->save($item);
                }
            }
        } catch (\Exception $e) {
            Log::error('unable to sync feed', ['exception' => $e]);
            return false;
        }

        return true;
    }
}
