<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211224115524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE email_verification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE player_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE email_verification (id INT NOT NULL, email VARCHAR(40) NOT NULL, code VARCHAR(5) NOT NULL, attempts SMALLINT NOT NULL, blocked_until TIMESTAMP(6) WITHOUT TIME ZONE DEFAULT NULL, expires TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN email_verification.blocked_until IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN email_verification.expires IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE player (id INT NOT NULL, nickname citext NOT NULL, email VARCHAR(40) NOT NULL, password VARCHAR(255) NOT NULL, rating SMALLINT NOT NULL, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65A188FE64 ON player (nickname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65E7927C74 ON player (email)');
        $this->addSql('COMMENT ON COLUMN player.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE email_verification_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE player_id_seq CASCADE');
        $this->addSql('DROP TABLE email_verification');
        $this->addSql('DROP TABLE player');
    }
}
