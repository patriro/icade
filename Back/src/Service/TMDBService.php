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
        $url = 'https://api.themoviedb.org/3/movie/popular?api_key=5da2ecaef1b84326dfa73e2a59680d72&language=fr&page=' . $pageNumber;

        if (!is_null($genreId)) {
            $url = 'https://api.themoviedb.org/3/discover/movie?api_key=5da2ecaef1b84326dfa73e2a59680d72&language=fr&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres=' . $genreId . '&page=' . $pageNumber;
        }

        if (!is_null($term)) {
            $url = 'https://api.themoviedb.org/3/search/movie?api_key=5da2ecaef1b84326dfa73e2a59680d72&language=fr&query=' . $term . '&page=1&include_adult=false&page=' . $pageNumber;
        }

        try {
            $response = $this->tmdb->request(
                'GET',
                $url
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
                'https://api.themoviedb.org/3/movie/' . $id . '?api_key=5da2ecaef1b84326dfa73e2a59680d72&language=fr&append_to_response=videos'
            );
            $headers = $response->getHeaders();

            return $response->toArray();
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }
}
