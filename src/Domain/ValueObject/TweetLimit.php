<?php

namespace App\Domain\ValueObject;

class TweetLimit
{
    private const MAX_LIMIT = 10;

    private int $limit;

    public function __construct(int $limit)
    {
        $this->validateLimit($limit);
        $this->limit = $limit;
    }

    public function getValue(): int
    {
        return $this->limit;
    }

    private function validateLimit(int $limit): void
    {
        if ($limit > self::MAX_LIMIT) {
            throw new \InvalidArgumentException('Tweet limit cannot exceed ' . self::MAX_LIMIT);
        }
    }
}