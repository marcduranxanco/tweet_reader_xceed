<?php

namespace App\Application\Controller;

use App\Domain\Service\TweetService;
use App\Domain\ValueObject\TweetLimit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class TweetConverterController extends AbstractController
{
    private const CACHE_TTL = 3600;

    private TweetService $tweetService;
    private CacheInterface $cache;

    public function __construct(TweetService $tweetService, CacheInterface $cache)
    {
        $this->tweetService = $tweetService;
        $this->cache = $cache;
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

        $cacheKey = $this->getCacheKey($userName, $limit->getValue());

        $tweets = $this->cache->get($cacheKey, function (ItemInterface $item) use ($userName, $limit) {
            $item->expiresAfter(self::CACHE_TTL);
            $tweets = $this->tweetService->searchByUserNameUpperCase($userName, $limit);
            return $tweets;
        });

        return new JsonResponse($tweets);
    }

    private function getCacheKey(string $userName, int $limit) : string
    {
        return sprintf('tweets_%s_%d', $userName, $limit);
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
