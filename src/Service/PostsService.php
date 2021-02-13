<?php

namespace App\Service;

use App\Dto\PostDto;
use App\Dto\PostsListParams;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Utils\DataMappers\PostMapper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use Symfony\Component\Security\Core\Security;

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
     * @var PostMapper
     */
    protected $mapper;

    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * @var Security
     */
    private $security;

    /**
     * @param EntityManagerInterface $em
     * @param PostMapper $mapper
     * @param Security $security
     */
    public function __construct(
        EntityManagerInterface $em,
        PostMapper $mapper,
        Security $security
    ) {
        $this->em = $em;
        $this->mapper = $mapper;
        $this->repository = $this->em->getRepository(Post::class);
        $this->security = $security;
    }

    /**
     * Returns post with specified ID
     *
     * @param string $id
     * @param string $userId
     *
     * @return null|Post
     */
    public function find(string $id, string $userId = ''): ?Post
    {
        /** @var Post $post */
        if (null !== $userId) {
            $post = $this->repository->findOneBy(['id' => $id, 'createdBy' => $userId]);
        } else {
            $post = $this->repository->find($id);
        }

        return $post;
    }

    /**
     * Returns post with specified ID
     *
     * @param string $id
     *
     * @return null|PostDto
     */
    public function get(string $id): ?PostDto
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

            $post = $this->mapper->toEntity($postDto, $this->security->getUser());

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
     * Update specified post
     *
     * @param PostDto $postDto
     * @param Post $post
     *
     * @return PostDto
     * @throws Exception
     */
    public function update(PostDto $postDto, Post $post): PostDto
    {
        try {
            $this->em->beginTransaction();

            $this->mapper->updatePost($post, $postDto);

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
