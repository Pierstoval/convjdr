<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250126222448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user timezone and fix default values for boolean fields';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            ALTER TABLE user
                ADD timezone VARCHAR(255) DEFAULT 'Europe/Paris' NOT NULL,
                CHANGE is_email_confirmed is_email_confirmed TINYINT(1) DEFAULT 0 NOT NULL,
                CHANGE is_verified is_verified TINYINT(1) DEFAULT 0 NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE `user`
                DROP timezone, 
                CHANGE is_email_confirmed is_email_confirmed TINYINT(1) NOT NULL, 
                CHANGE is_verified is_verified TINYINT(1) NOT NULL
        SQL);
    }
}
