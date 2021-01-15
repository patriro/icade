<?php

namespace App\Entity;

use App\Filter\GenreFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 *  @ApiResource(
 *      collectionOperations={"get"},
 *      itemOperations={"get"}
 *  )
 * @ApiFilter(GenreFilter::class, properties={"genre"})
 */
class Movie
{
    /**
     * @ApiProperty(identifier=true)
     */
    private $id;

    private $title;

    private $releaseDate;

    private $originTitle;

    private $overview;

    private $img;

    private $genre = [];

    private $keyVideo;

    private $voteAVG;

    private $voteCount;

    private $pageNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(string $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getOriginTitle(): ?string
    {
        return $this->originTitle;
    }

    public function setOriginTitle(string $originTitle): self
    {
        $this->originTitle = $originTitle;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = 'https://image.tmdb.org/t/p/w200/' . $img;

        return $this;
    }

    public function getGenre(): ?array
    {
        return $this->genre;
    }

    public function setGenre(array $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getKeyVideo(): ?string
    {
        return $this->keyVideo;
    }

    public function setKeyVideo($keyVideo): self
    {
        if (!is_null($keyVideo)) {
            $this->keyVideo = 'https://www.youtube.com/embed/' . $keyVideo;
        }

        return $this;
    }

    public function getVoteAVG(): ?string
    {
        return $this->voteAVG;
    }

    public function setVoteAVG(string $voteAVG): self
    {
        $this->voteAVG = $voteAVG;

        return $this;
    }

    public function getVoteCount(): ?int
    {
        return $this->voteCount;
    }

    public function setVoteCount(int $voteCount): self
    {
        $this->voteCount = $voteCount;

        return $this;
    }

    public function getPageNumber(): ?int
    {
        return $this->pageNumber;
    }

    public function setPageNumber(int $pageNumber): self
    {
        $this->pageNumber = $pageNumber;

        return $this;
    }
}
