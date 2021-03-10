<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617120713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE market_categories_categories ADD parent_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN market_categories_categories.parent_id IS \'(DC2Type:market_categories_category_id)\'');
        $this->addSql('ALTER TABLE market_categories_categories ADD CONSTRAINT FK_143BDCDF727ACA70 FOREIGN KEY (parent_id) REFERENCES market_categories_categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_143BDCDF727ACA70 ON market_categories_categories (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE market_categories_categories DROP CONSTRAINT FK_143BDCDF727ACA70');
        $this->addSql('DROP INDEX IDX_143BDCDF727ACA70');
        $this->addSql('ALTER TABLE market_categories_categories DROP parent_id');
    }
}
