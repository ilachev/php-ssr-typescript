<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617081112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE market_categories_settings (id UUID NOT NULL, version INT DEFAULT 1 NOT NULL, template_seo_heading VARCHAR(255) DEFAULT NULL, template_seo_title VARCHAR(255) DEFAULT NULL, template_seo_description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN market_categories_settings.id IS \'(DC2Type:market_categories_setting_id)\'');
        $this->addSql('CREATE TABLE market_promos_settings (id UUID NOT NULL, version INT DEFAULT 1 NOT NULL, template_seo_heading VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN market_promos_settings.id IS \'(DC2Type:market_promos_setting_id)\'');
        $this->addSql('CREATE TABLE market_stores_settings (id UUID NOT NULL, version INT DEFAULT 1 NOT NULL, template_seo_heading VARCHAR(255) DEFAULT NULL, template_seo_title VARCHAR(255) DEFAULT NULL, template_seo_description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN market_stores_settings.id IS \'(DC2Type:market_stores_setting_id)\'');

        $this->addSql('INSERT INTO market_categories_settings (id, version, template_seo_heading, template_seo_title, template_seo_description) VALUES (\'cd88b8a0-72c5-444f-ac42-55fa1bfd17fd\', 1, NULL, NULL, NULL)');
        $this->addSql('INSERT INTO market_promos_settings (id, version, template_seo_heading) VALUES (\'39a86956-122c-487a-88cc-66dd5b50e124\', 1, NULL)');
        $this->addSql('INSERT INTO market_stores_settings (id, version, template_seo_heading, template_seo_title, template_seo_description) VALUES (\'bbf53b31-84da-4856-a262-bb5549451b4e\', 1, NULL, NULL, NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE market_categories_settings');
        $this->addSql('DROP TABLE market_promos_settings');
        $this->addSql('DROP TABLE market_stores_settings');
    }
}
