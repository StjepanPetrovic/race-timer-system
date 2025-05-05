<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250505072511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE leaderboard (id SERIAL NOT NULL, race_id INT DEFAULT NULL, runner_id INT DEFAULT NULL, position INT NOT NULL, finish_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_182E52536E59D40D ON leaderboard (race_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_182E52533C7FB593 ON leaderboard (runner_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN leaderboard.finish_time IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN leaderboard.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE leaderboard ADD CONSTRAINT FK_182E52536E59D40D FOREIGN KEY (race_id) REFERENCES race (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE leaderboard ADD CONSTRAINT FK_182E52533C7FB593 FOREIGN KEY (runner_id) REFERENCES runner (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE leaderboard DROP CONSTRAINT FK_182E52536E59D40D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE leaderboard DROP CONSTRAINT FK_182E52533C7FB593
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE leaderboard
        SQL);
    }
}
