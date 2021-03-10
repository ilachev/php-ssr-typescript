<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226091455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE blog_authors ADD update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN blog_authors.update_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE blog_categories_categories ADD update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN blog_categories_categories.update_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE blog_posts_post_comments ADD update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN blog_posts_post_comments.update_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE blog_posts_posts ADD update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN blog_posts_posts.update_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE market_authors ADD update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN market_authors.update_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE market_categories_categories ADD update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN market_categories_categories.update_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE market_promos_promos ADD update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN market_promos_promos.update_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE market_stores_store_comments ADD update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN market_stores_store_comments.update_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE market_stores_stores ADD update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN market_stores_stores.update_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_users ADD update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN user_users.update_date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE blog_authors DROP update_date');
        $this->addSql('ALTER TABLE blog_categories_categories DROP update_date');
        $this->addSql('ALTER TABLE blog_posts_posts DROP update_date');
        $this->addSql('ALTER TABLE blog_posts_post_comments DROP update_date');
        $this->addSql('ALTER TABLE market_stores_store_comments DROP update_date');
        $this->addSql('ALTER TABLE user_users DROP update_date');
        $this->addSql('ALTER TABLE market_authors DROP update_date');
        $this->addSql('ALTER TABLE market_categories_categories DROP update_date');
        $this->addSql('ALTER TABLE market_promos_promos DROP update_date');
        $this->addSql('ALTER TABLE market_stores_stores DROP update_date');
    }
}
