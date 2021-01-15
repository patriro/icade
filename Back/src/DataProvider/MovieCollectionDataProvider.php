<?php
namespace App\DataProvider;

use App\Entity\Movie;
use App\Service\TMDBService;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class MovieCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $tmdbService;

    private $itemExtensions;

    public function __construct(iterable $itemExtensions, TMDBService $tmdbService)
    {
        $this->itemExtensions = $itemExtensions;
        $this->tmdbService = $tmdbService;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Movie::class === $resourceClass && $operationName === 'get';
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $genreId = null;

        if (!empty($context["filters"]) && array_key_exists("genre", $context["filters"])) {
            $genreId = $context["filters"]["genre"];
        }

        $results = $this->tmdbService->findAllMovies($genreId);

        $page = $results["page"];

        foreach($results["results"] as $result) {
            yield (new Movie())
                ->setId($result["id"])
                ->setTitle($result["title"])
                ->setOriginTitle($result["original_title"])
                ->setReleaseDate($result["release_date"])
                ->setImg($result["poster_path"])
                ->setOverview($result["overview"])
                ->setGenre($result["genre_ids"])
                ->setVoteAVG($result["vote_average"])
                ->setVoteCount($result["vote_count"])
            ;
        }
    }
}