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
        if (!is_numeric($limit)) {
            throw new \InvalidArgumentException('Invalid TweetLimit value');
        }

        $limit = (int)$limit;

        if ($limit <= 0) {
            throw new \InvalidArgumentException('Tweet limit must be greather than 0');
        }

        if ($limit > self::MAX_LIMIT) {
            throw new \InvalidArgumentException('Tweet limit cannot exceed ' . self::MAX_LIMIT);
        }
    }
}