<?php

namespace App\Command;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Utils\KafkaHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @package App\Command
 */
class PostVoteCommand extends Command
{
    use KafkaHelper;

    /**
     * @var string
     */
    protected static $defaultName = 'post:vote';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $kafkaHost;

    /**
     * @var string
     */
    protected $kafkaPort;

    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setDescription('Run kafka listener for new messages');
    }

    /**
     * @param string $kafkaHost
     * @param string $kafkaPort
     * @param EntityManagerInterface $em
     */
    public function __construct(string $kafkaHost = '', string $kafkaPort = '', EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
        $this->kafkaHost = $kafkaHost;
        $this->kafkaPort = $kafkaPort;
        $this->repository = $this->em->getRepository(Post::class);
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $consumer = $this->configureConsumer($this->kafkaHost, $this->kafkaPort);
        $consumer->start(
            function ($topic, $part, $message) {
                $postId = $message['message']['key'];
                $value = $message['message']['value'];

                /** @var Post $post */
                $post = $this->repository->find($postId);
                if (null !== $post) {
                    $voteValue = 1;
                    if ($value === 'true') {
                        $voteValue = -1;
                    }
                    $post->setRating($post->getRating() + $voteValue);
                    $this->em->flush();
                }
            }
        );

        return 1;
    }
}
