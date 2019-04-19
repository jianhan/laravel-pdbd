<?php

namespace App\FeedReader;

interface ReaderInterface
{
    public function read(): ?Feed;

    public function getRawContent(): String;
}
