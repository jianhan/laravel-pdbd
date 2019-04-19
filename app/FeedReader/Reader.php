<?php

namespace App\FeedReader;

use FeedIo\FeedInterface;
use Illuminate\Support\Facades\Log;

class Reader implements ReaderInterface
{
    private $rawContent;

    private $url;

    private function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function getInstance(string $url): ReaderInterface
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

    public function read(): ?FeedInterface
    {
        try {
            // create a simple FeedIo instance
            $feedIo = \FeedIo\Factory::create()->getFeedIo();
            // read a feed
            $result = $feedIo->read($this->url);

            // store raw content
            $document = $result->getDocument();
            if ($document->isJson()) {
                $this->rawContent = json_encode($document->getJsonAsArray());
            } elseif ($document->isXml()) {
                $this->rawContent = $document->getDOMDocument()->saveXML();
            }

            return $result->getFeed();
        } catch (\Exception $e) {
            Log::error('unable to fetch feed', ['exception' => $e]);
            return null;
        }
    }
}
