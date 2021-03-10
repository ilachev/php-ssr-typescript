<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201130190500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE blog_posts_post_logos (id UUID NOT NULL, post_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, info_path VARCHAR(255) NOT NULL, info_name VARCHAR(255) NOT NULL, info_size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EE7C4B684B89032C ON blog_posts_post_logos (post_id)');
        $this->addSql('CREATE INDEX IDX_EE7C4B68AA9E377A ON blog_posts_post_logos (date)');
        $this->addSql('COMMENT ON COLUMN blog_posts_post_logos.id IS \'(DC2Type:blog_posts_post_logo_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_posts_post_logos.post_id IS \'(DC2Type:blog_posts_post_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_posts_post_logos.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE blog_posts_post_logos ADD CONSTRAINT FK_EE7C4B684B89032C FOREIGN KEY (post_id) REFERENCES blog_posts_posts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE blog_posts_post_logos');
    }
}
