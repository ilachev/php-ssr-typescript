<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617052235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE market_promos_promos (id INT NOT NULL, store_id UUID NOT NULL, author_id UUID NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, discount INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, type VARCHAR(16) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, status VARCHAR(16) DEFAULT \'active\' NOT NULL, version INT DEFAULT 1 NOT NULL, seo_heading VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FFA1C29CB092A811 ON market_promos_promos (store_id)');
        $this->addSql('CREATE INDEX IDX_FFA1C29CF675F31B ON market_promos_promos (author_id)');
        $this->addSql('CREATE INDEX IDX_FFA1C29CAA9E377A95275AB8845CBB3E ON market_promos_promos (date, start_date, end_date)');
        $this->addSql('COMMENT ON COLUMN market_promos_promos.id IS \'(DC2Type:market_promos_promo_id)\'');
        $this->addSql('COMMENT ON COLUMN market_promos_promos.store_id IS \'(DC2Type:market_stores_store_id)\'');
        $this->addSql('COMMENT ON COLUMN market_promos_promos.author_id IS \'(DC2Type:market_author_id)\'');
        $this->addSql('COMMENT ON COLUMN market_promos_promos.type IS \'(DC2Type:market_promos_promo_type)\'');
        $this->addSql('COMMENT ON COLUMN market_promos_promos.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN market_promos_promos.start_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN market_promos_promos.end_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN market_promos_promos.status IS \'(DC2Type:market_promos_promo_status)\'');
        $this->addSql('CREATE TABLE market_stores_store_logos (id UUID NOT NULL, store_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, info_path VARCHAR(255) NOT NULL, info_name VARCHAR(255) NOT NULL, info_size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_766E6517B092A811 ON market_stores_store_logos (store_id)');
        $this->addSql('CREATE INDEX IDX_766E6517AA9E377A ON market_stores_store_logos (date)');
        $this->addSql('COMMENT ON COLUMN market_stores_store_logos.id IS \'(DC2Type:market_stores_store_logo_id)\'');
        $this->addSql('COMMENT ON COLUMN market_stores_store_logos.store_id IS \'(DC2Type:market_stores_store_id)\'');
        $this->addSql('COMMENT ON COLUMN market_stores_store_logos.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE market_stores_stores (id UUID NOT NULL, author_id UUID NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(16) DEFAULT \'active\' NOT NULL, sort INT DEFAULT 0 NOT NULL, version INT DEFAULT 1 NOT NULL, info_detail TEXT DEFAULT NULL, info_contacts TEXT DEFAULT NULL, info_payment TEXT DEFAULT NULL, info_delivery TEXT DEFAULT NULL, seo_heading VARCHAR(255) DEFAULT NULL, seo_title VARCHAR(255) DEFAULT NULL, seo_description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9CD080989D9B62 ON market_stores_stores (slug)');
        $this->addSql('CREATE INDEX IDX_A9CD080F675F31B ON market_stores_stores (author_id)');
        $this->addSql('CREATE INDEX IDX_A9CD080AA9E377A5124F222 ON market_stores_stores (date, sort)');
        $this->addSql('COMMENT ON COLUMN market_stores_stores.id IS \'(DC2Type:market_stores_store_id)\'');
        $this->addSql('COMMENT ON COLUMN market_stores_stores.author_id IS \'(DC2Type:market_author_id)\'');
        $this->addSql('COMMENT ON COLUMN market_stores_stores.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN market_stores_stores.status IS \'(DC2Type:market_stores_store_status)\'');
        $this->addSql('CREATE TABLE market_categories_categories (id UUID NOT NULL, author_id UUID NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(16) DEFAULT \'active\' NOT NULL, sort INT DEFAULT 0 NOT NULL, version INT DEFAULT 1 NOT NULL, seo_heading VARCHAR(255) DEFAULT NULL, seo_title VARCHAR(255) DEFAULT NULL, seo_description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_143BDCDF989D9B62 ON market_categories_categories (slug)');
        $this->addSql('CREATE INDEX IDX_143BDCDFF675F31B ON market_categories_categories (author_id)');
        $this->addSql('CREATE INDEX IDX_143BDCDFAA9E377A5124F222 ON market_categories_categories (date, sort)');
        $this->addSql('COMMENT ON COLUMN market_categories_categories.id IS \'(DC2Type:market_categories_category_id)\'');
        $this->addSql('COMMENT ON COLUMN market_categories_categories.author_id IS \'(DC2Type:market_author_id)\'');
        $this->addSql('COMMENT ON COLUMN market_categories_categories.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN market_categories_categories.status IS \'(DC2Type:market_categories_category_status)\'');
        $this->addSql('CREATE TABLE category_store (category_id UUID NOT NULL, store_id UUID NOT NULL, PRIMARY KEY(category_id, store_id))');
        $this->addSql('CREATE INDEX IDX_1764173E12469DE2 ON category_store (category_id)');
        $this->addSql('CREATE INDEX IDX_1764173EB092A811 ON category_store (store_id)');
        $this->addSql('COMMENT ON COLUMN category_store.category_id IS \'(DC2Type:market_categories_category_id)\'');
        $this->addSql('COMMENT ON COLUMN category_store.store_id IS \'(DC2Type:market_stores_store_id)\'');
        $this->addSql('CREATE TABLE market_categories_category_logos (id UUID NOT NULL, category_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, info_path VARCHAR(255) NOT NULL, info_name VARCHAR(255) NOT NULL, info_size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8B3548A12469DE2 ON market_categories_category_logos (category_id)');
        $this->addSql('CREATE INDEX IDX_D8B3548AAA9E377A ON market_categories_category_logos (date)');
        $this->addSql('COMMENT ON COLUMN market_categories_category_logos.id IS \'(DC2Type:market_categories_category_logo_id)\'');
        $this->addSql('COMMENT ON COLUMN market_categories_category_logos.category_id IS \'(DC2Type:market_categories_category_id)\'');
        $this->addSql('COMMENT ON COLUMN market_categories_category_logos.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE market_authors (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(16) NOT NULL, version INT DEFAULT 1 NOT NULL, name_first VARCHAR(255) NOT NULL, name_last VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN market_authors.id IS \'(DC2Type:market_author_id)\'');
        $this->addSql('COMMENT ON COLUMN market_authors.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN market_authors.email IS \'(DC2Type:market_author_email)\'');
        $this->addSql('COMMENT ON COLUMN market_authors.status IS \'(DC2Type:market_author_status)\'');
        $this->addSql('ALTER TABLE market_promos_promos ADD CONSTRAINT FK_FFA1C29CB092A811 FOREIGN KEY (store_id) REFERENCES market_stores_stores (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market_promos_promos ADD CONSTRAINT FK_FFA1C29CF675F31B FOREIGN KEY (author_id) REFERENCES market_authors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market_stores_store_logos ADD CONSTRAINT FK_766E6517B092A811 FOREIGN KEY (store_id) REFERENCES market_stores_stores (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market_stores_stores ADD CONSTRAINT FK_A9CD080F675F31B FOREIGN KEY (author_id) REFERENCES market_authors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market_categories_categories ADD CONSTRAINT FK_143BDCDFF675F31B FOREIGN KEY (author_id) REFERENCES market_authors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_store ADD CONSTRAINT FK_1764173E12469DE2 FOREIGN KEY (category_id) REFERENCES market_categories_categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_store ADD CONSTRAINT FK_1764173EB092A811 FOREIGN KEY (store_id) REFERENCES market_stores_stores (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market_categories_category_logos ADD CONSTRAINT FK_D8B3548A12469DE2 FOREIGN KEY (category_id) REFERENCES market_categories_categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE SEQUENCE market_promos_promo_seq INCREMENT BY 1 MINVALUE 1 START 1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE market_promos_promo_seq CASCADE');
        $this->addSql('ALTER TABLE market_promos_promos DROP CONSTRAINT FK_FFA1C29CB092A811');
        $this->addSql('ALTER TABLE market_stores_store_logos DROP CONSTRAINT FK_766E6517B092A811');
        $this->addSql('ALTER TABLE category_store DROP CONSTRAINT FK_1764173EB092A811');
        $this->addSql('ALTER TABLE category_store DROP CONSTRAINT FK_1764173E12469DE2');
        $this->addSql('ALTER TABLE market_categories_category_logos DROP CONSTRAINT FK_D8B3548A12469DE2');
        $this->addSql('ALTER TABLE market_promos_promos DROP CONSTRAINT FK_FFA1C29CF675F31B');
        $this->addSql('ALTER TABLE market_stores_stores DROP CONSTRAINT FK_A9CD080F675F31B');
        $this->addSql('ALTER TABLE market_categories_categories DROP CONSTRAINT FK_143BDCDFF675F31B');
        $this->addSql('DROP TABLE market_promos_promos');
        $this->addSql('DROP TABLE market_stores_store_logos');
        $this->addSql('DROP TABLE market_stores_stores');
        $this->addSql('DROP TABLE market_categories_categories');
        $this->addSql('DROP TABLE category_store');
        $this->addSql('DROP TABLE market_categories_category_logos');
        $this->addSql('DROP TABLE market_authors');
    }
}
