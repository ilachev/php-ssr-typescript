<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127153859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE blog_categories_categories (id UUID NOT NULL, author_id UUID NOT NULL, parent_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(16) DEFAULT \'active\' NOT NULL, sort INT DEFAULT 0 NOT NULL, version INT DEFAULT 1 NOT NULL, seo_heading VARCHAR(255) DEFAULT NULL, seo_title VARCHAR(255) DEFAULT NULL, seo_description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2CF1E8B989D9B62 ON blog_categories_categories (slug)');
        $this->addSql('CREATE INDEX IDX_2CF1E8BF675F31B ON blog_categories_categories (author_id)');
        $this->addSql('CREATE INDEX IDX_2CF1E8B727ACA70 ON blog_categories_categories (parent_id)');
        $this->addSql('CREATE INDEX IDX_2CF1E8BAA9E377A5124F222 ON blog_categories_categories (date, sort)');
        $this->addSql('COMMENT ON COLUMN blog_categories_categories.id IS \'(DC2Type:blog_categories_category_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_categories_categories.author_id IS \'(DC2Type:blog_author_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_categories_categories.parent_id IS \'(DC2Type:blog_categories_category_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_categories_categories.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN blog_categories_categories.status IS \'(DC2Type:blog_categories_category_status)\'');
        $this->addSql('CREATE TABLE category_post (category_id UUID NOT NULL, post_id UUID NOT NULL, PRIMARY KEY(category_id, post_id))');
        $this->addSql('CREATE INDEX IDX_D11116CA12469DE2 ON category_post (category_id)');
        $this->addSql('CREATE INDEX IDX_D11116CA4B89032C ON category_post (post_id)');
        $this->addSql('COMMENT ON COLUMN category_post.category_id IS \'(DC2Type:blog_categories_category_id)\'');
        $this->addSql('COMMENT ON COLUMN category_post.post_id IS \'(DC2Type:blog_posts_post_id)\'');
        $this->addSql('CREATE TABLE blog_categories_settings (id UUID NOT NULL, version INT DEFAULT 1 NOT NULL, template_seo_heading VARCHAR(255) DEFAULT NULL, template_seo_title VARCHAR(255) DEFAULT NULL, template_seo_description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN blog_categories_settings.id IS \'(DC2Type:blog_categories_setting_id)\'');
        $this->addSql('CREATE TABLE blog_posts_posts (id UUID NOT NULL, author_id UUID NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(16) DEFAULT \'active\' NOT NULL, sort INT DEFAULT 0 NOT NULL, version INT DEFAULT 1 NOT NULL, seo_heading VARCHAR(255) DEFAULT NULL, seo_description TEXT DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_description TEXT DEFAULT NULL, meta_og_title VARCHAR(255) DEFAULT NULL, meta_og_description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E36A7D15989D9B62 ON blog_posts_posts (slug)');
        $this->addSql('CREATE INDEX IDX_E36A7D15F675F31B ON blog_posts_posts (author_id)');
        $this->addSql('CREATE INDEX IDX_E36A7D15AA9E377A5124F222 ON blog_posts_posts (date, sort)');
        $this->addSql('COMMENT ON COLUMN blog_posts_posts.id IS \'(DC2Type:blog_posts_post_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_posts_posts.author_id IS \'(DC2Type:blog_author_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_posts_posts.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN blog_posts_posts.status IS \'(DC2Type:blog_posts_post_status)\'');
        $this->addSql('CREATE TABLE blog_posts_settings (id UUID NOT NULL, version INT DEFAULT 1 NOT NULL, template_seo_heading VARCHAR(255) DEFAULT NULL, template_seo_description TEXT DEFAULT NULL, template_meta_title VARCHAR(255) DEFAULT NULL, template_meta_description TEXT DEFAULT NULL, template_meta_og_title VARCHAR(255) DEFAULT NULL, template_meta_og_description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN blog_posts_settings.id IS \'(DC2Type:blog_posts_setting_id)\'');
        $this->addSql('ALTER TABLE blog_categories_categories ADD CONSTRAINT FK_2CF1E8BF675F31B FOREIGN KEY (author_id) REFERENCES blog_authors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blog_categories_categories ADD CONSTRAINT FK_2CF1E8B727ACA70 FOREIGN KEY (parent_id) REFERENCES blog_categories_categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_post ADD CONSTRAINT FK_D11116CA12469DE2 FOREIGN KEY (category_id) REFERENCES blog_categories_categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_post ADD CONSTRAINT FK_D11116CA4B89032C FOREIGN KEY (post_id) REFERENCES blog_posts_posts (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blog_posts_posts ADD CONSTRAINT FK_E36A7D15F675F31B FOREIGN KEY (author_id) REFERENCES blog_authors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE blog_categories_categories DROP CONSTRAINT FK_2CF1E8B727ACA70');
        $this->addSql('ALTER TABLE category_post DROP CONSTRAINT FK_D11116CA12469DE2');
        $this->addSql('ALTER TABLE category_post DROP CONSTRAINT FK_D11116CA4B89032C');
        $this->addSql('DROP TABLE blog_categories_categories');
        $this->addSql('DROP TABLE category_post');
        $this->addSql('DROP TABLE blog_categories_settings');
        $this->addSql('DROP TABLE blog_posts_posts');
        $this->addSql('DROP TABLE blog_posts_settings');
    }
}
