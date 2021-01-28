<?php

namespace App\Service;

use App\Dto\PostDto;
use App\Dto\PostsListParams;
use App\Dto\UserDto;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Utils\DataMappers\PostMapper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
     * @var PostRepository
     */
    protected $repository;

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
        $this->repository = $this->em->getRepository(Post::class);
    }

    /**
     * Returns post with specified ID
     *
     * @param string $id
     *
     * @return null|PostDto
     */
    public function get(string $id)
    {
        /** @var Post|null $post */
        $post = $this->repository->find($id);

        if (null === $post) {
            return null;
        }

        return $this->mapper->toDto($post);
    }

    /**
     * Returns list of posts according to specified params
     *
     * @param PostsListParams $params
     *
     * @return PostDto[]
     */
    public function getList(PostsListParams $params): array
    {
        $postsDto = [];
        $posts = $this->repository->getList($params);

        foreach ($posts as $post) {
            $postsDto[] = $this->mapper->toDto($post);
        }

        return $postsDto;
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

    /**
     * Returns total number of posts according to specified params
     *
     * @param PostsListParams $params
     *
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getCount(PostsListParams $params): int
    {
        return $this->repository->getCount($params);
    }
}
