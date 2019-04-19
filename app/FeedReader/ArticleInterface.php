<?php

namespace App\FeedReader;

use Illuminate\Support\Collection;

interface ArticleInterface
{
    public function getTitle(): String;

    public function getAuthor(): String;

    public function getCategories(): Collection;

    public function getDescription(): String;

    public function getPublicId(): String;

    public function getLastModified(): \DateTime;

    public function getLink(): String;

    public function getDCDate(): \DateTime;
}
