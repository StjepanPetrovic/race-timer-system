<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430080549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE race (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN race.date IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE result (id SERIAL NOT NULL, race_id INT DEFAULT NULL, runner_id INT DEFAULT NULL, time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_136AC1136E59D40D ON result (race_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_136AC1133C7FB593 ON result (runner_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN result.time IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE runner (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, surname VARCHAR(100) NOT NULL, start_number INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F92B8B3E5C5F88C4 ON runner (start_number)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE result ADD CONSTRAINT FK_136AC1136E59D40D FOREIGN KEY (race_id) REFERENCES race (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE result ADD CONSTRAINT FK_136AC1133C7FB593 FOREIGN KEY (runner_id) REFERENCES runner (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE result DROP CONSTRAINT FK_136AC1136E59D40D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE result DROP CONSTRAINT FK_136AC1133C7FB593
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE race
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE result
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE runner
        SQL);
    }
}
