<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223121003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE blog_posts_post_comments (id UUID NOT NULL, post_id UUID NOT NULL, author_id UUID NOT NULL, parent_id UUID DEFAULT NULL, status VARCHAR(16) DEFAULT \'draft\' NOT NULL, text TEXT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, version INT DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_44A4F80A4B89032C ON blog_posts_post_comments (post_id)');
        $this->addSql('CREATE INDEX IDX_44A4F80AF675F31B ON blog_posts_post_comments (author_id)');
        $this->addSql('CREATE INDEX IDX_44A4F80A727ACA70 ON blog_posts_post_comments (parent_id)');
        $this->addSql('CREATE INDEX IDX_44A4F80AAA9E377A ON blog_posts_post_comments (date)');
        $this->addSql('COMMENT ON COLUMN blog_posts_post_comments.id IS \'(DC2Type:blog_posts_post_comment_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_posts_post_comments.post_id IS \'(DC2Type:blog_posts_post_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_posts_post_comments.author_id IS \'(DC2Type:blog_author_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_posts_post_comments.parent_id IS \'(DC2Type:blog_posts_post_comment_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_posts_post_comments.status IS \'(DC2Type:blog_posts_post_comment_status)\'');
        $this->addSql('COMMENT ON COLUMN blog_posts_post_comments.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE blog_posts_post_comments ADD CONSTRAINT FK_44A4F80A4B89032C FOREIGN KEY (post_id) REFERENCES blog_posts_posts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blog_posts_post_comments ADD CONSTRAINT FK_44A4F80AF675F31B FOREIGN KEY (author_id) REFERENCES blog_authors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blog_posts_post_comments ADD CONSTRAINT FK_44A4F80A727ACA70 FOREIGN KEY (parent_id) REFERENCES blog_posts_post_comments (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE blog_posts_post_comments DROP CONSTRAINT FK_44A4F80A727ACA70');
        $this->addSql('DROP TABLE blog_posts_post_comments');
    }
}
