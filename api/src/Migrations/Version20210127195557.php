<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210127195557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE market_stores_store_comments (id UUID NOT NULL, store_id UUID NOT NULL, author_id UUID NOT NULL, parent_id UUID DEFAULT NULL, status VARCHAR(16) DEFAULT \'draft\' NOT NULL, text TEXT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, version INT DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E3B7AF9BB092A811 ON market_stores_store_comments (store_id)');
        $this->addSql('CREATE INDEX IDX_E3B7AF9BF675F31B ON market_stores_store_comments (author_id)');
        $this->addSql('CREATE INDEX IDX_E3B7AF9B727ACA70 ON market_stores_store_comments (parent_id)');
        $this->addSql('CREATE INDEX IDX_E3B7AF9BAA9E377A ON market_stores_store_comments (date)');
        $this->addSql('COMMENT ON COLUMN market_stores_store_comments.id IS \'(DC2Type:market_stores_store_comment_id)\'');
        $this->addSql('COMMENT ON COLUMN market_stores_store_comments.store_id IS \'(DC2Type:market_stores_store_id)\'');
        $this->addSql('COMMENT ON COLUMN market_stores_store_comments.author_id IS \'(DC2Type:market_author_id)\'');
        $this->addSql('COMMENT ON COLUMN market_stores_store_comments.parent_id IS \'(DC2Type:market_stores_store_comment_id)\'');
        $this->addSql('COMMENT ON COLUMN market_stores_store_comments.status IS \'(DC2Type:market_stores_store_comment_status)\'');
        $this->addSql('COMMENT ON COLUMN market_stores_store_comments.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE market_stores_store_comments ADD CONSTRAINT FK_E3B7AF9BB092A811 FOREIGN KEY (store_id) REFERENCES market_stores_stores (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market_stores_store_comments ADD CONSTRAINT FK_E3B7AF9BF675F31B FOREIGN KEY (author_id) REFERENCES market_authors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market_stores_store_comments ADD CONSTRAINT FK_E3B7AF9B727ACA70 FOREIGN KEY (parent_id) REFERENCES market_stores_store_comments (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE market_stores_store_comments DROP CONSTRAINT FK_E3B7AF9B727ACA70');
        $this->addSql('DROP TABLE market_stores_store_comments');
    }
}
