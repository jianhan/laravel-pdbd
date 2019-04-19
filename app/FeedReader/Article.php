<?php

namespace App\FeedReader;

use Illuminate\Support\Collection;

class Article implements ArticleInterface
{
    private $title;

    private $author;

    private $categories;

    private $description;

    private $publicId;

    private $lastModified;

    private $link;

    private $dcDate;

    public function getTitle(): String
    {
        return $this->title;
    }

    public function getAuthor(): String
    {
        return $this->author;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function getDescription(): String
    {
        return $this->description;
    }

    public function getPublicId(): String
    {
        return $this->publicId;
    }

    public function getLastModified(): \DateTime
    {
        return $this->lastModified;
    }

    public function getLink(): String
    {
        return $this->link;
    }

    public function getDCDate(): \DateTime
    {
        return $this->dcDate;
    }

    public function setTitle(String $title): ArticleInterface
    {
        $this->title = $title;

        return $this;
    }

    public function setAuthor(String $author): ArticleInterface
    {
        $this->author = $author;

        return $this;
    }

    public function setCategories(Collection $categories): ArticleInterface
    {
        $this->categories = $categories;

        return $this;
    }

    public function setDescription(String $description): ArticleInterface
    {
        $this->description = $description;

        return $this;
    }

    public function setPublicId(String $publicId): ArticleInterface
    {
        $this->publicId = $publicId;

        return $this;
    }

    public function setLastModified(\DateTime $lastModified): ArticleInterface
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    public function setLink(String $link): ArticleInterface
    {
        $this->link = $link;

        return $this;
    }

    public function setDcDate(\DateTime $dcDate): ArticleInterface
    {
        $this->dcDate = $dcDate;

        return $this;
    }
}
