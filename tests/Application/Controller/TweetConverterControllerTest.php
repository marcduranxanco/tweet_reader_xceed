<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TweetConverterControllerTest extends WebTestCase
{
    public function testIndexActionShouldReturnValidJson()
    {
        $client = static::createClient();
        $client->request('GET', '/tweets/jackDorsey?limit=2');
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }


    /**
     * @dataProvider provideInvalidLimits
     */
    public function testInvalidLimit($invalidLimit, $expectedErrorMessage)
    {
        $client = static::createClient();
        $client->request('GET', '/tweets/jackDorsey?limit=' . $invalidLimit);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame($expectedErrorMessage, $responseData['error']);
    }

    public function provideInvalidLimits()
    {
        return [
            ['invalid', 'Invalid argument limit provided.'],
            ['abc', 'Invalid argument limit provided.'],
            ['1.5', 'Invalid argument limit provided.'],
            ['-1', 'Tweet limit must be greater than 0'],
        ];
    }

    /**
     * @dataProvider provideLimitsAboveMaximum
     */
    public function testLimitAboveMaximum($limit)
    {
        $client = static::createClient();
        $client->request('GET', '/tweets/jackDorsey?limit=' . $limit);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame('Tweet limit cannot exceed 10', $responseData['error']);
    }

    public function provideLimitsAboveMaximum()
    {
        return [
            [11],
            [20],
            [100],
        ];
    }
}