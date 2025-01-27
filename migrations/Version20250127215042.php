<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250127215042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove unnecessary TimeSlot::$name';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE time_slot DROP name');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE time_slot ADD name VARCHAR(255) NOT NULL');
    }
}
