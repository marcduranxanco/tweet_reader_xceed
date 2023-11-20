<?php

namespace App\Application\Controller;

use App\Domain\ValueObject\TweetLimit;
use App\Infrastructure\TweetRepositoryInMemory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TweetConverterController extends AbstractController
{
    /**
     * @Route("/tweets/{userName}", methods={"GET"})
     *
     * @param TweetRepositoryInMemory $repo
     * @param Request                 $request
     * @param                         $userName
     *
     * @return JsonResponse
     */
    public function index(TweetRepositoryInMemory $repo, Request $request, $userName)
    {
        try {
            $limit = $this->getTweetLimitFromRequest($request);
        } catch (\InvalidArgumentException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $tweets = $repo->searchByUserName($userName, $limit);

        $tweetsResponse = [];
        foreach($tweets as $tweet){
            $tweetText = strtoupper($tweet->getText());
            array_push($tweetsResponse, $tweetText);
        }

        return new JsonResponse($tweetsResponse);
    }

    private function getTweetLimitFromRequest(Request $request): TweetLimit
    {
        $limit = $request->query->get('limit');

        if (!is_numeric($limit)) {
            throw new \InvalidArgumentException('Invalid argument limit provided.', Response::HTTP_BAD_REQUEST);
        }

        return new TweetLimit($limit);
    }
}
