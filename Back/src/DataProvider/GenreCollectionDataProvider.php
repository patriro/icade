<?php
namespace App\DataProvider;

use App\Entity\Genre;
use App\Service\TMDBService;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class GenreCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $tmdbService;

    public function __construct(TMDBService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Genre::class === $resourceClass && $operationName === 'get';
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $response = $this->tmdbService->findAllGenres();
        $results = $response->toArray();

        foreach($results["genres"] as $result) {
            yield new Genre($result["id"], $result["name"]);
        }
    }
}