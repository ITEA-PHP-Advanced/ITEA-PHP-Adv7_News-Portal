<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200913113318 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE UNIQUE INDEX UNIQ_AD005B69E7927C74 ON subscriber (email)
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP INDEX UNIQ_AD005B69E7927C74 ON subscriber
        SQL);
    }
}
