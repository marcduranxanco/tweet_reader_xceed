<?php

namespace App\Infrastructure;

use App\Domain\ValueObject\TweetLimit;

interface TweetRepository
{
    public function searchByUserName(string $username, TweetLimit $limit): array;
}
