<?php

namespace App\Service;

use App\Dto\PostDto;
use App\Dto\UserDto;
use App\Utils\DataMappers\PostMapper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Service for posts
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Service
 */
class PostsService
{
    /**
     * Entity manager interface
     *
     * @var EntityManager
     */
    protected $em;

    /**
     * Event dispatcher
     *
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var PostMapper
     */
    protected $mapper;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     * @param EventDispatcherInterface $dispatcher
     * @param LoggerInterface $logger
     * @param PostMapper $mapper
     */
    public function __construct(
        EntityManagerInterface $em,
        EventDispatcherInterface $dispatcher,
        LoggerInterface $logger,
        PostMapper $mapper
    ) {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
        $this->mapper = $mapper;
    }

    /**
     * @param PostDto $postDto
     *
     * @return PostDto
     * @throws Exception
     */
    public function create(PostDto $postDto): PostDto
    {
        try {
            $this->em->beginTransaction();

            $createdBy = (new UserDto())->setId(Uuid::uuid4()); // TODO remove after auth realization
            $postDto->setCreatedBy($createdBy);

            $post = $this->mapper->toEntity($postDto);

            $this->em->persist($post);
            $this->em->flush();

            $this->em->commit();

            return $this->mapper->toDto($post);
        } catch (Exception $e) {
            $this->em->rollback();

            throw $e;
        }
    }
}
