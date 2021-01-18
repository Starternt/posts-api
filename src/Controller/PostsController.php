<?php

namespace App\Controller;

use App\Utils\JsonApi\JsonApiErrorsTrait;
use Exception;
use Psr\Log\LoggerInterface;
use Reva2\JsonApi\Annotations\ApiRequest;
use Reva2\JsonApi\Contracts\Services\JsonApiServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Controller that implements posts API
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Controller
 */
class PostsController extends JsonApiController
{
    use JsonApiErrorsTrait;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Security
     */
    protected $security;

    /**
     * @param JsonApiServiceInterface $jsonApiService
     * @param LoggerInterface $logger
     * @param Security $security
     */
    public function __construct(
        JsonApiServiceInterface $jsonApiService,
        LoggerInterface $logger,
        Security $security
    ) {
        parent::__construct($jsonApiService);

        $this->logger = $logger;
        $this->security = $security;
    }

    /**
     * Create post
     *
     * @param Request $request
     *
     * @Route("/v1/posts", methods={"POST"}, name="posts.create")
     * @ApiRequest(
     *     body="App\Dto\PostDocument",
     *     serialization={"Default", "CreatePost"}, validation={"Default", "CreatePost"}
     * )
     * @return Response
     * @throws Exception
     */
    public function create(Request $request)
    {
        dump(666); exit();
        $apiRequest = $this->jsonApiService->parseRequest($request);
        /* @var $post Post */
        $post = $apiRequest->getBody()->data;

        $this->service->create($post);

        // return $this->buildEmptyResponse($apiRequest, Response::HTTP_NO_CONTENT);
    }
}
