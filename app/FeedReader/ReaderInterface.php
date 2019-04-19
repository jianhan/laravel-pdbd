<?php

namespace App\FeedReader;

use FeedIo\FeedInterface;

interface ReaderInterface
{
    public function read(): ?FeedInterface;

    public function getRawContent(): String;
}
