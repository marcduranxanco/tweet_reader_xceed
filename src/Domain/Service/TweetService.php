<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\TweetLimit;
use App\Infrastructure\TweetRepositoryInMemory;

class TweetService
{
    private $tweetRepository;

    public function __construct(TweetRepositoryInMemory $tweetRepository)
    {
        $this->tweetRepository = $tweetRepository;
    }

    public function getTweetsByUserName(string $userName, TweetLimit $limit): array
    {
        $tweets = $this->tweetRepository->searchByUserName($userName, $limit);

        $tweetsResponse = [];
        foreach ($tweets as $tweet) {
            array_push($tweetsResponse, $tweet->getText());
        }

        return $tweetsResponse;
    }

    public function searchByUserNameUpperCase(string $username, TweetLimit $limit): array
    {
        $tweets = $this->getTweetsByUserName($username, $limit);

        foreach ($tweets as $key => $tweet) {
            $tweets[$key] = strtoupper($tweet);
        }

        return $tweets;
    }
}