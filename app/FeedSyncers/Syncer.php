<?php

namespace App\FeedSyncers;

use App\FeedReader\ReaderInterface;
use App\Models\Article;
use App\Models\Feed as FeedModel;

class Syncer implements SyncerInterface
{
    private $feedModel;

    private $reader;

    public function __construct(FeedModel $feedModel, ReaderInterface $reader)
    {
        $this->feedModel = $feedModel;
        $this->reader = $reader;
    }

    public function sync()
    {
        if ($feed = $this->reader->read()) {
            // update feed
            $this->feedModel->title = $feed->title;
            $this->feedModel->last_synced_at = \Carbon\Carbon::now();
            $this->feedModel->description = $feed->description;
            $this->feedModel->last_modified_at = $feed->lastModified;

            // update articles
            if (isset($feed->articles)) {
                foreach ($feed->articles as $article) {
                    $article = Article::updateOrCreate(
                        ['guid' => md5($article->publicId), 'feed_id' => $this->feedModel->id],
                        [
                            'title' => $article->title,
                            'link' => $article->link,
                            'description' => $article->description,
                            'content' => $article->content,
                            'pub_date' => $article->pubDate ? $article->pubDate->format('Y-m-d H:i:s') : null,
                            'creator' => $article->author,
                            'timestamp' => $article->lastModified ? $article->lastModified->getTimestamp() : null,
                        ]
                    );
                }
            }
        }
    }
}
