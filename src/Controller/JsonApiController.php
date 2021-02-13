<?php

namespace App\Controller;

use Neomerx\JsonApi\Contracts\Document\ErrorInterface;
use Neomerx\JsonApi\Exceptions\ErrorCollection;
use Reva2\JsonApi\Contracts\Http\RequestInterface;
use Reva2\JsonApi\Contracts\Services\JsonApiServiceInterface;
use Reva2\JsonApi\Http\Query\ListQueryParameters;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Konstnatin Laktionov <Starternh@gmail.com>
 * @package App\Controller
 */
abstract class JsonApiController
{
    /**
     * @var JsonApiServiceInterface
     */
    protected $jsonApiService;

    /**
     * Constructor
     *
     * @param JsonApiServiceInterface $jsonApiService
     */
    public function __construct(JsonApiServiceInterface $jsonApiService)
    {
        $this->jsonApiService = $jsonApiService;
    }

    /**
     * Creates response with regular JSON API document in body
     *
     * @param RequestInterface $request
     * @param mixed $data
     * @param mixed|null $metadata
     * @param int $code
     * @param array $links
     * @param array $headers
     *
     * @return Response
     */
    protected function buildContentResponse(
        RequestInterface $request,
        $data,
        $metadata = null,
        $code = Response::HTTP_OK,
        array $links = [],
        array $headers = []
    ): Response {
        return $this->jsonApiService
            ->getResponseFactory($request)
            ->getContentResponse($data, $code, $links, $metadata, $headers);
    }

    /**
     * Creates response with JSON API Error
     *
     * @param RequestInterface $request
     * @param ErrorInterface|ErrorInterface[]|ErrorCollection $errors
     * @param int $code
     * @param array $headers
     *
     * @return Response
     */
    protected function buildErrorResponse(
        RequestInterface $request,
        $errors,
        $code = Response::HTTP_BAD_REQUEST,
        array $headers = []
    ): Response {
        return $this->jsonApiService->getResponseFactory($request)->getErrorResponse($errors, $code, $headers);
    }

    /**
     * Returns metadata for list response
     *
     * @param ListQueryParameters $parameters
     *
     * @return array
     */
    protected function getListResponseMetadata(ListQueryParameters $parameters): array
    {
        return ['page' => $parameters->getPaginationParameters()];
    }
}