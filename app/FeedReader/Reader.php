<?php

namespace App\FeedReader;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Reader implements ReaderInterface
{
    private $rawContent;

    private $url;

    private function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function getReader(string $url): ReaderInterface
    {
        if (trim($url) === '') {
            throw new \Exception('empty url, unable to get feed instance');
        }

        return new self($url);
    }

    public function getRawContent(): String
    {
        return $this->rawContent;
    }

    public function read(): ?Feed
    {
        $feed = new Feed();

        try {
            // create a simple FeedIo instance
            $feedIo = \FeedIo\Factory::create(['builder' => 'monolog'])->getFeedIo();
            // read a feed
            $result = $feedIo->read($this->url);

            // store raw content
            $document = $result->getDocument();
            if ($document->isJson()) {
                $this->rawContent = json_encode($document->getJsonAsArray());
            } elseif ($document->isXml()) {
                $this->rawContent = $document->getDOMDocument()->saveXML();
            }

            // generate feed
            $resultFeed = $result->getFeed();
            $feed->link = $resultFeed->getLink();
            $feed->date = $result->getDate();
            $feed->title = $resultFeed->getTitle();
            $feed->description = $resultFeed->getDescription();
            $feed->lastBuildDate = $resultFeed->getLastModified();
            $feed->getPublicId = $resultFeed->getPublicId();
            $feed->rawContent = $this->rawContent;

            // generate feed articles
            $feed->articles = new Collection();
            foreach ($resultFeed as $item) {
                $article = new Article();
                $article->title = $item->getTitle();
                $article->link = $item->getLink();
                $article->author = $item->getAuthor();
                $article->description = $item->getDescription();
                $article->lastModified = $item->getLastModified();
                $article->publicId = $item->getPublicId();
                $articleCategories = new Collection();
                foreach ($item->getCategories() as $category) {
                    $articleCategories->add($category->getTerm());
                }
                $feed->articles->add($item);
            }
        } catch (\Exception $e) {
            Log::error('unable to fetch feed', ['exception' => $e]);
            return null;
        }

        return $feed;
    }
}
