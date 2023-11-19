<?php

namespace App\Tests\Domain\ValueObject;

use App\Domain\ValueObject\TweetLimit;
use PHPUnit\Framework\TestCase;

class TweetLimitTest extends TestCase
{
    public function testValidTweetLimit(): void
    {
        $validLimit = 5;

        $tweetLimit = new TweetLimit($validLimit);

        $this->assertSame($validLimit, $tweetLimit->getValue());
    }

    public function testInvalidTweetLimit(): void
    {
        $invalidLimit = 15;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Tweet limit cannot exceed 10');

        new TweetLimit($invalidLimit);
    }

    public function testInvalidType(): void
    {
        $this->expectException(\TypeError::class);
        new TweetLimit('abc');
    }

    public function testNegativeValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new TweetLimit(-5);
    }
}
