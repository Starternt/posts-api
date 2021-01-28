<?php

namespace App\Controller;

use App\Dto\PostDto;
use App\Service\PostsService;
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
     * @var PostsService
     */
    protected $service;

    /**
     * @param JsonApiServiceInterface $jsonApiService
     * @param LoggerInterface $logger
     * @param Security $security
     * @param PostsService $service
     */
    public function __construct(
        JsonApiServiceInterface $jsonApiService,
        LoggerInterface $logger,
        Security $security,
        PostsService $service
    ) {
        parent::__construct($jsonApiService);

        $this->logger = $logger;
        $this->security = $security;
        $this->service = $service;
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
    public function create(Request $request): Response
    {
        $apiRequest = $this->jsonApiService->parseRequest($request);

        /* @var $post PostDto */
        $post = $apiRequest->getBody()->data;

        $postDto = $this->service->create($post);

        return $this->buildContentResponse($apiRequest, $postDto);
    }
}
