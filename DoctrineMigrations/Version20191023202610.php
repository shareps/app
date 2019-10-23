<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191023202610 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE parking_availabilities (id VARCHAR(22) NOT NULL, places INT NOT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN parking_availabilities.from_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN parking_availabilities.to_date IS \'(DC2Type:date_immutable)\'');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE accounting_tasks (id VARCHAR(22) NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE parking_member_needs (id VARCHAR(22) NOT NULL, member_id VARCHAR(22) DEFAULT NULL, date DATE NOT NULL, places INT NOT NULL, reason VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_899a921e7597d3fe ON parking_member_needs (member_id)');
        $this->addSql('CREATE UNIQUE INDEX parking_member_needs_date_member_uidx ON parking_member_needs (date, member_id)');
        $this->addSql('COMMENT ON COLUMN parking_member_needs.date IS \'(DC2Type:date_immutable)\'');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE parking_availability_breaks (id VARCHAR(22) NOT NULL, places INT NOT NULL, reason VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_7adc18caa9e377a ON parking_availability_breaks (date)');
        $this->addSql('COMMENT ON COLUMN parking_availability_breaks.date IS \'(DC2Type:date_immutable)\'');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE access_users (id VARCHAR(22) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_fd16d9bae7927c74 ON access_users (email)');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE parking_reservations (id VARCHAR(22) NOT NULL, member_id VARCHAR(22) DEFAULT NULL, date DATE NOT NULL, type VARCHAR(50) NOT NULL, places INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX parking_reservations_date_member_uidx ON parking_reservations (date, member_id)');
        $this->addSql('CREATE INDEX idx_81af1b3a7597d3fe ON parking_reservations (member_id)');
        $this->addSql('COMMENT ON COLUMN parking_reservations.date IS \'(DC2Type:date_immutable)\'');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE access_slack_identities (id VARCHAR(22) NOT NULL, user_id VARCHAR(22) NOT NULL, slack_id VARCHAR(16) NOT NULL, email VARCHAR(255) NOT NULL, team_id VARCHAR(16) NOT NULL, name VARCHAR(255) NOT NULL, is_deleted BOOLEAN NOT NULL, color VARCHAR(6) NOT NULL, real_name VARCHAR(255) NOT NULL, tz VARCHAR(63) NOT NULL, tz_label VARCHAR(63) NOT NULL, tz_offset INT NOT NULL, is_admin BOOLEAN NOT NULL, is_bot BOOLEAN NOT NULL, updated INT NOT NULL, is_app_user BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_5b43a04a76ed395 ON access_slack_identities (user_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_5b43a04e7927c74 ON access_slack_identities (email)');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE parking_members (id VARCHAR(22) NOT NULL, user_id VARCHAR(22) DEFAULT NULL, name VARCHAR(255) NOT NULL, points INT NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_cb4a2a25a76ed395 ON parking_members (user_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_cb4a2a255e237e06 ON parking_members (name)');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE access_google_identities (id VARCHAR(22) NOT NULL, user_id VARCHAR(22) NOT NULL, google_id VARCHAR(25) NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, given_name VARCHAR(255) NOT NULL, family_name VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_a12bac6e7927c74 ON access_google_identities (email)');
        $this->addSql('CREATE UNIQUE INDEX uniq_a12bac676f5c865 ON access_google_identities (google_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_a12bac6a76ed395 ON access_google_identities (user_id)');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE accounting_journal_moves (id VARCHAR(22) NOT NULL, member_id VARCHAR(22) NOT NULL, journal_id VARCHAR(22) NOT NULL, given_points INT NOT NULL, received_points VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_c68d82a478e8802 ON accounting_journal_moves (journal_id)');
        $this->addSql('CREATE INDEX idx_c68d82a7597d3fe ON accounting_journal_moves (member_id)');
        $this->addSql('COMMENT ON COLUMN accounting_journal_moves.date IS \'(DC2Type:date_immutable)\'');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE parking_memberships (id VARCHAR(22) NOT NULL, member_id VARCHAR(22) DEFAULT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_daf589a27597d3fe ON parking_memberships (member_id)');
        $this->addSql('COMMENT ON COLUMN parking_memberships.from_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN parking_memberships.to_date IS \'(DC2Type:date_immutable)\'');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE accounting_journals (id VARCHAR(22) NOT NULL, journal_id VARCHAR(22) NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_ab267833478e8802 ON accounting_journals (journal_id)');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE system_request_log_details (id VARCHAR(22) NOT NULL, request_log_id VARCHAR(22) NOT NULL, path TEXT NOT NULL, meta TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_4f124cf4a13e9e7d ON system_request_log_details (request_log_id)');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE system_request_logs (id VARCHAR(22) NOT NULL, member_id VARCHAR(22) DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, finished_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, type VARCHAR(50) NOT NULL, "group" VARCHAR(255) NOT NULL, mili_seconds INT NOT NULL, successfull BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_9c1bc9ab7597d3fe ON system_request_logs (member_id)');
        $this->addSql('COMMENT ON COLUMN system_request_logs.started_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN system_request_logs.finished_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE parking_availabilities');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE accounting_tasks');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE parking_member_needs');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE parking_availability_breaks');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE access_users');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE parking_reservations');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE access_slack_identities');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE parking_members');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE access_google_identities');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE accounting_journal_moves');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE parking_memberships');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE accounting_journals');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE system_request_log_details');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE system_request_logs');
    }
}
