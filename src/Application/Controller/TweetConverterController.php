<?php

namespace App\Application\Controller;

use App\Infrastructure\TweetRepositoryInMemory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        $tweets = $repo->searchByUserName($userName, 10);

        $tweetsResponse = [];
        foreach($tweets as $tweet){
            $tweetText = strtoupper($tweet->getText());
            array_push($tweetsResponse, $tweetText);
        }

        return new JsonResponse($tweetsResponse);
    }
}
