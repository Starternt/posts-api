<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126002516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'posts table creation';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(
            'CREATE TABLE `posts` (
                  `id` varchar(36) NOT NULL,
                  `title` varchar (250) NOT NULL COMMENT \'Post title\',
                  `createdBy` varchar(36) NOT NULL COMMENT \'User which created a post\',
                  `rating` int(7) NOT NULL DEFAULT 0 COMMENT \'Current rating of a post\',
                  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'Date of creation\',
                  `updatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'Last date of post update\',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT=\'Posts table\';'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE `posts`');
    }
}
