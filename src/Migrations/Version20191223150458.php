<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191223150458 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Test migration';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE `reply_status_server` (
              `repliedAt` int(11) NOT NULL AUTO_INCREMENT,
              PRIMARY KEY (`repliedAt`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT=\'Check\'
        ');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE `reply_status_server`;');
    }
}
