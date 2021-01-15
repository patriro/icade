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
            'query' => [
                'api_key' => $this->apiKey,
                'language' => 'fr',
                ]
        ];
    }

    public function findAllGenres()
    {
        try {
            $response = $this->tmdb->request(
                'GET',
                '/3/genre/movie/list',
                $this->defaultParam(),
            );
            $headers = $response->getHeaders();

            return $response;
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }

    public function findAllMovies($genreId, $term, $pageNumber)
    {
        $url = '/3/movie/popular?page=' . $pageNumber;

        if (!is_null($genreId)) {
            $url = '/3/discover/movie?sort_by=popularity.desc&with_genres=' . $genreId . '&page=' . $pageNumber;
        }

        if (!is_null($term)) {
            $url = '/3/search/movie?query=' . $term . '&page=' . $pageNumber;
        }

        try {
            $response = $this->tmdb->request(
                'GET',
                $url,
                $this->defaultParam()
            );
            $headers = $response->getHeaders();

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }

    public function findMovieById($id)
    {
        try {
            $response = $this->tmdb->request(
                'GET',
                '/3/movie/' . $id . '?append_to_response=videos',
                $this->defaultParam(),
            );
            $headers = $response->getHeaders();

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }
}
