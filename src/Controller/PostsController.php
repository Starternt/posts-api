<?php

namespace App\Controller;

use App\Dto\PostDto;
use App\Dto\PostsListParams;
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
     * @param PostsService $service
     * @param Security $security
     */
    public function __construct(JsonApiServiceInterface $jsonApiService, PostsService $service, Security $security)
    {
        parent::__construct($jsonApiService);

        $this->service = $service;
        $this->security = $security;
    }

    /**
     * Returns info about specified post
     *
     * @param Request $request
     * @param string $id
     *
     * @Route("/v1/posts/{id}", methods={"GET"}, name="posts.info", requirements={"id"="[0-9a-zA-z-]+"})
     * @ApiRequest(query="App\Dto\PostParams")
     *
     * @return Response
     * @throws Exception
     */
    public function get(Request $request, string $id): Response
    {
        $apiRequest = $this->jsonApiService->parseRequest($request);

        $post = $this->service->get($id);
        if (null === $post) {
            throw $this->createNotFoundException(sprintf('Post #%s not found', $id));
        }

        return $this->buildContentResponse($apiRequest, $post);
    }

    /**
     * Returns list of posts according to specified params
     *
     * @param Request $request
     *
     * @Route("/v1/posts", methods={"GET"}, name="posts.list")
     * @ApiRequest(query="App\Dto\PostsListParams")
     *
     * @return Response
     * @throws Exception
     */
    public function getList(Request $request): Response
    {
        $apiRequest = $this->jsonApiService->parseRequest($request);

        /* @var $query PostsListParams */
        $query = $apiRequest->getQuery();

        $groups = $this->service->getList($query);
        $metadata = $this->getListResponseMetadata($query);
        $metadata['total'] = $this->service->getCount($query);

        return $this->buildContentResponse($apiRequest, $groups, $metadata);
    }

    /**
     * Create post
     *
     * @param Request $request
     *
     * @Route("/v1/posts", methods={"POST"}, name="posts.create")
     * @ApiRequest(
     *     query="App\Dto\PostParams",
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

    /**
     * Updates specified post
     *
     * @param Request $request
     * @param string $id
     *
     * @Route("/v1/posts/{id}", methods={"PATCH"}, name="posts.update", requirements={"id"="[0-9a-zA-z-]+"})
     * @ApiRequest(
     *     query="App\Dto\PostParams",
     *     body="App\Dto\PostDocument",
     *     serialization={"Default", "UpdatePost"}, validation={"Default", "UpdatePost"}
     * )
     *
     * @return Response
     * @throws Exception
     */
    public function update(Request $request, string $id): Response
    {
        $post = $this->service->find($id, (string)$this->security->getUser()->getId());
        if (null === $post) {
            throw $this->createNotFoundException(sprintf("Post #%d not found", $id));
        }

        $apiRequest = $this->jsonApiService->parseRequest($request);

        /* @var $postDto PostDto */
        $postDto = $apiRequest->getBody()->data;

        $postDto = $this->service->update($postDto, $post);

        return $this->buildContentResponse($apiRequest, $postDto);
    }
}
