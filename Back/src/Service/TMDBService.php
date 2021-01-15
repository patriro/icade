<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TMDBService
{
    private $tmdb;

    private $apiKey;

    public function __construct(HttpClientInterface $tmdb, $apiKey)
    {
        $this->tmdb = $tmdb;
        $this->apiKey = $apiKey;
    }

    private function defaultParam()
    {
        return [
            'api_key' => $this->apiKey,
            'language' => 'fr',
        ];
    }

    private function buildCustomParam($customParams)
    {
        $defaultParams = $this->defaultParam();

        return [
            'query' => array_merge($customParams, $defaultParams),
        ];
    }

    public function findAllGenres()
    {
        try {
            $response = $this->tmdb->request(
                'GET',
                '/3/genre/movie/list',
                $this->buildCustomParam([]),
            );
            // Can also trigger an error if the request doesn't
            $headers = $response->getHeaders();

            return $response;
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }

    public function findMovies($genreId, $term, $pageNumber)
    {
        $url = '/3/movie/popular';
        $customParams = [
            'page' => $pageNumber,
        ];

        if (!is_null($genreId)) {
            $url = '/3/discover/movie';
            $customParams = [
                'sort_by' => 'popularity.desc',
                'with_genres' => $genreId,
                'page' => $pageNumber,
            ];
        }

        if (!is_null($term)) {
            $url = '/3/search/movie';
            $customParams = [
                'query' => $term,
                'page' => $pageNumber,
            ];
        }

        try {
            $response = $this->tmdb->request(
                'GET',
                $url,
                $this->buildCustomParam($customParams)
            );
            $headers = $response->getHeaders();

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }

    public function findMovieById($id)
    {
        $customParams = [
            'append_to_response' => 'videos'
        ];
        try {
            $response = $this->tmdb->request(
                'GET',
                '/3/movie/' . $id,
                $this->buildCustomParam($customParams),
            );
            $headers = $response->getHeaders();

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }
}
