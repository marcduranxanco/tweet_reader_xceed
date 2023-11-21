<?php

namespace App\Application\Controller;

use App\Domain\Service\TweetService;
use App\Domain\ValueObject\TweetLimit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TweetConverterController extends AbstractController
{
    private TweetService $tweetService;

    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    /**
     * @Route("/tweets/{userName}", methods={"GET"})
     *
     * @param Request                 $request
     * @param                         $userName
     *
     * @return JsonResponse
     */
    public function index(Request $request, $userName)
    {
        try {
            $limit = $this->getTweetLimitFromRequest($request);
        } catch (\InvalidArgumentException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $tweets = $this->tweetService->searchByUserNameUpperCase($userName, $limit);

        return new JsonResponse($tweets);
    }

    private function getTweetLimitFromRequest(Request $request): TweetLimit
    {
        $limit = $request->query->get('limit');

        if (!is_numeric($limit)) {
            throw new \InvalidArgumentException('Invalid argument limit provided.', Response::HTTP_BAD_REQUEST);
        }

        if (!filter_var($limit, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException('Invalid argument limit provided.', Response::HTTP_BAD_REQUEST);
        }

        return new TweetLimit($limit);
    }
}
