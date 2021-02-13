<?php

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Reva2\JsonApi\Annotations\Id;

/**
 * Post entity
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @Id()
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=250)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="string", name="createdBy", length=36)
     */
    protected $createdBy;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="createdBy", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $rating;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime_immutable", name="createdAt")
     */
    protected $createdAt;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime", name="updatedAt")
     */
    protected $updatedAt;

    /**
     * @var Content[]
     * @ORM\OneToMany(targetEntity="Content", mappedBy="post", orphanRemoval=true, cascade={"all"})
     */
    protected $content;

    /**
     * Constructor and initializes collections
     */
    public function __construct()
    {
        $this->content = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Post
     */
    public function setId(string $id): Post
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Post
     */
    public function setTitle(string $title): Post
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * @param string $createdBy
     *
     * @return Post
     */
    public function setCreatedBy(string $createdBy): Post
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Post
     */
    public function setUser(User $user): Post
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     *
     * @return Post
     */
    public function setRating(int $rating): Post
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @return Post
     */
    public function setCreatedAt(DateTimeInterface $createdAt): Post
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface $updatedAt
     *
     * @return Post
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): Post
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Content[]
     */
    public function getContent(): array
    {
        return $this->content->toArray();
    }

    /**
     * @param Content[] $content
     *
     * @return Post
     */
    public function setContent(array $content): Post
    {
        $this->content->clear();
        foreach ($content as $contentItem) {
            $contentItem->setPost($this);
            $this->content->add($contentItem);
        }

        return $this;
    }
}
