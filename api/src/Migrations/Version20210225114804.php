<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225114804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE market_promos_promo_referral_links (id UUID NOT NULL, promo_id INT NOT NULL, link TEXT NOT NULL, internal_id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, version INT DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3F9BFF66D0C07AFF ON market_promos_promo_referral_links (promo_id)');
        $this->addSql('CREATE INDEX IDX_3F9BFF66AA9E377ABFDFB4D8 ON market_promos_promo_referral_links (date, internal_id)');
        $this->addSql('COMMENT ON COLUMN market_promos_promo_referral_links.id IS \'(DC2Type:market_promos_promo_referral_link_id)\'');
        $this->addSql('COMMENT ON COLUMN market_promos_promo_referral_links.promo_id IS \'(DC2Type:market_promos_promo_id)\'');
        $this->addSql('COMMENT ON COLUMN market_promos_promo_referral_links.internal_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN market_promos_promo_referral_links.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE market_promos_promo_referral_links ADD CONSTRAINT FK_3F9BFF66D0C07AFF FOREIGN KEY (promo_id) REFERENCES market_promos_promos (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE market_promos_promos DROP address');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE market_promos_promo_referral_links');
        $this->addSql('ALTER TABLE market_promos_promos ADD address VARCHAR(255) DEFAULT NULL');
    }
}
