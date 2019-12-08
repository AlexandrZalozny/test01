<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191203191920 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `tblProductData`	ADD COLUMN `intStock` INT NOT NULL AFTER `stmTimestamp`');
        $this->addSql('ALTER TABLE `tblProductData`	ADD COLUMN `dblCost` DOUBLE NOT NULL AFTER `stmTimestamp`');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE `tblProductData`	DROP COLUMN `intStock`');
        $this->addSql('ALTER TABLE `tblProductData`	DROP COLUMN `dblCost`');

    }
}
