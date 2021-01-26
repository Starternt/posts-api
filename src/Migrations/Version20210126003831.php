<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126003831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'content table creation';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(
            'CREATE TABLE `content` (
                  `id` varchar(36) NOT NULL,
                  `postId` varchar (36) NOT NULL COMMENT \'Post id\',
                  `type` enum(\'text\',\'image\',\'video\') NOT NULL COMMENT \'Content type: text, image or video\',
                  `imageId` varchar(36) COMMENT \'Image id\',
                  `body` text COMMENT \'content body\',
                  `position` int (3) NOT NULL DEFAULT 1 COMMENT \'position of content which determine order\',
                  UNIQUE KEY `UQ_ImageId` (`imageId`),
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT=\'Content table\';'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE `content`');
    }
}
