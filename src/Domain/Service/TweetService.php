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
            $tweetText = strtoupper($tweet->getText());
            array_push($tweetsResponse, $tweetText);
        }

        return $tweetsResponse;
    }
}