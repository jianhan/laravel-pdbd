<?php

namespace App\Syncers;

use App\Models\Article as ArticleModel;
use App\Models\Feed;
use Feed as FeedReader;

class Article
{
    private $feed;
    private $feedResponse;

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    public function sync()
    {
        try {
            // retrieve feed
            $this->feedResponse = FeedReader::load($this->feed->link);

            // update feed title and description at the same time
            if ($this->feed->title == '' || $this->feed->description == '') {
                $this->feed->title = $this->feedResponse->title->__toString();
                $this->feed->description = $this->feedResponse->description->__toString();
                $this->feed->save();
            }

            // update articles
            if (isset($this->feedResponse->item) && count($this->feedResponse->item) > 0) {
                foreach ($this->feedResponse->item as $item) {
                    ArticleModel::updateOrCreate([
                        'guid' => md5($item->guid->__toString()),
                        'feed_id' => $this->feed->id,
                    ], [
                        'title' => $item->title->__toString(),
                        'description' => $item->description->__toString(),
                        'pub_date' => date("D, d M Y H:i:s T", strtotime($item->pubDate->__toString()))
                            ->format('Y-m-d H:i:s'),
                        'creator' => $item->{'dc:creator'}->__toString(),
                        'timestamp' => $item->timestamp->__toString(),
                    ]);
                }
            } else {
                // TODO: log warning
            }
        } catch (\Exception $e) {
            // TOOD: log here
        }
    }
}
