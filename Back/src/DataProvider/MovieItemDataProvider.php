<?php
// api/src/DataProvider/BlogPostItemDataProvider.php

namespace App\DataProvider;

use App\Entity\Movie;
use App\Service\TMDBService;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;

final class MovieItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $tmdbService;

    public function __construct(TMDBService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Movie::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Movie
    {
        $result = $this->tmdbService->findMovieById($id);
        $video = $result["videos"]["results"][0]["key"] ?? null;

        return (new Movie())
            ->setId($result["id"])
            ->setTitle($result["title"])
            ->setOriginTitle($result["original_title"])
            ->setReleaseDate($result["release_date"])
            ->setImg($result["poster_path"])
            ->setOverview($result["overview"])
            ->setKeyVideo($video)
            ->setVoteAVG($result["vote_average"])
            ->setVoteCount($result["vote_count"])
        ;
    }
}
