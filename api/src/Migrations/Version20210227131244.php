<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227131244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE market_categories_categories ADD meta_description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE market_categories_categories ADD meta_og_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE market_categories_categories ADD meta_og_description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE market_categories_categories RENAME COLUMN seo_title TO meta_title');
        $this->addSql('ALTER TABLE market_categories_settings ADD template_meta_description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE market_categories_settings ADD template_meta_og_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE market_categories_settings ADD template_meta_og_description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE market_categories_settings RENAME COLUMN template_seo_title TO template_meta_title');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE market_categories_categories ADD seo_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE market_categories_categories DROP meta_title');
        $this->addSql('ALTER TABLE market_categories_categories DROP meta_description');
        $this->addSql('ALTER TABLE market_categories_categories DROP meta_og_title');
        $this->addSql('ALTER TABLE market_categories_categories DROP meta_og_description');
        $this->addSql('ALTER TABLE market_categories_settings ADD template_seo_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE market_categories_settings DROP template_meta_title');
        $this->addSql('ALTER TABLE market_categories_settings DROP template_meta_description');
        $this->addSql('ALTER TABLE market_categories_settings DROP template_meta_og_title');
        $this->addSql('ALTER TABLE market_categories_settings DROP template_meta_og_description');
    }
}
