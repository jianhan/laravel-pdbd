<?php

namespace App\Syncers;

interface FeedReaderInterface
{
    public function read(): Feed;

    public function getRawContent(): String;
}
