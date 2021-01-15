<?php
namespace App\DataProvider;

use App\Entity\Movie;
use App\Service\TMDBService;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class MovieCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $tmdbService;

    public function __construct(TMDBService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Movie::class === $resourceClass && $operationName === 'get';
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $genreId = null;
        $term = null;
        $pageNumber = null;

        if (!empty($context["filters"]) && array_key_exists("genre", $context["filters"])) {
            $genreId = $context["filters"]["genre"];
        }

        if (!empty($context["filters"]) && array_key_exists("term", $context["filters"])) {
            $term = $context["filters"]["term"];
        }

        if (!empty($context["filters"]) && array_key_exists("page", $context["filters"])) {
            $pageNumber = $context["filters"]["page"];
        }

        $results = $this->tmdbService->findAllMovies($genreId, $term, $pageNumber);

        foreach($results["results"] as $result) {
            yield (new Movie())
                ->setId($result["id"])
                ->setTitle($result["title"] ?? null)
                ->setOriginTitle($result["original_title"] ?? null)
                ->setReleaseDate($result["release_date"] ?? null)
                ->setImg($result["poster_path"] ?? null)
                ->setOverview($result["overview"] ?? null)
                ->setGenre($result["genre_ids"] ?? null)
                ->setVoteAVG($result["vote_average"] ?? null)
                ->setVoteCount($result["vote_count"] ?? null)
            ;
        }
    }
}