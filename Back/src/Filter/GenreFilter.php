<?php
// api/src/Filter/RegexpFilter.php

namespace App\Filter;

use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ContextAwareFilterInterface;

final class GenreFilter extends AbstractContextAwareFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null) { }

    protected function splitPropertyParts(string $property): array { return []; }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

            $description["genre"] = [
                'property' => "genre",
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter by Genre',
                    'name' => 'Genre',
                    'type' => 'Will appear below the name in the Swagger documentation',
                ],
            ];

            $description["term"] = [
                'property' => "term",
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter by term',
                    'name' => 'Term',
                    'type' => 'Will appear below the name in the Swagger documentation',
                ],
            ];

        return $description;
    }
}
