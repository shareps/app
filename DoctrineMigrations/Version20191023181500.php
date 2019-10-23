<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191023181500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE accounting_journal_moves (id VARCHAR(22) NOT NULL, member_id VARCHAR(22) NOT NULL, journal_id VARCHAR(22) NOT NULL, given_points INT NOT NULL, received_points VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C68D82A7597D3FE ON accounting_journal_moves (member_id)');
        $this->addSql('CREATE INDEX IDX_C68D82A478E8802 ON accounting_journal_moves (journal_id)');
        $this->addSql('COMMENT ON COLUMN accounting_journal_moves.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE accounting_tasks (id VARCHAR(22) NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE accounting_journals (id VARCHAR(22) NOT NULL, journal_id VARCHAR(22) NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AB267833478E8802 ON accounting_journals (journal_id)');
        $this->addSql('CREATE TABLE parking_availabilities (id VARCHAR(22) NOT NULL, places INT NOT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN parking_availabilities.from_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN parking_availabilities.to_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE parking_member_needs (id VARCHAR(22) NOT NULL, member_id VARCHAR(22) DEFAULT NULL, date DATE NOT NULL, places INT NOT NULL, reason VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_899A921E7597D3FE ON parking_member_needs (member_id)');
        $this->addSql('CREATE UNIQUE INDEX parking_member_needs_date_member_uidx ON parking_member_needs (date, member_id)');
        $this->addSql('COMMENT ON COLUMN parking_member_needs.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE parking_memberships (id VARCHAR(22) NOT NULL, member_id VARCHAR(22) DEFAULT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DAF589A27597D3FE ON parking_memberships (member_id)');
        $this->addSql('COMMENT ON COLUMN parking_memberships.from_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN parking_memberships.to_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE parking_reservations (id VARCHAR(22) NOT NULL, member_id VARCHAR(22) DEFAULT NULL, date DATE NOT NULL, type VARCHAR(50) NOT NULL, places INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_81AF1B3A7597D3FE ON parking_reservations (member_id)');
        $this->addSql('CREATE UNIQUE INDEX parking_reservations_date_member_uidx ON parking_reservations (date, member_id)');
        $this->addSql('COMMENT ON COLUMN parking_reservations.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE parking_members (id VARCHAR(22) NOT NULL, user_id VARCHAR(22) DEFAULT NULL, name VARCHAR(255) NOT NULL, points INT NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB4A2A255E237E06 ON parking_members (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB4A2A25A76ED395 ON parking_members (user_id)');
        $this->addSql('CREATE TABLE parking_availability_breaks (id VARCHAR(22) NOT NULL, places INT NOT NULL, reason VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7ADC18CAA9E377A ON parking_availability_breaks (date)');
        $this->addSql('COMMENT ON COLUMN parking_availability_breaks.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE access_slack_identities (id VARCHAR(22) NOT NULL, user_id VARCHAR(22) NOT NULL, slack_id VARCHAR(16) NOT NULL, email VARCHAR(255) NOT NULL, team_id VARCHAR(16) NOT NULL, name VARCHAR(255) NOT NULL, is_deleted BOOLEAN NOT NULL, color VARCHAR(6) NOT NULL, real_name VARCHAR(255) NOT NULL, tz VARCHAR(63) NOT NULL, tz_label VARCHAR(63) NOT NULL, tz_offset INT NOT NULL, is_admin BOOLEAN NOT NULL, is_bot BOOLEAN NOT NULL, updated INT NOT NULL, is_app_user BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5B43A04E7927C74 ON access_slack_identities (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5B43A04A76ED395 ON access_slack_identities (user_id)');
        $this->addSql('CREATE TABLE access_users (id VARCHAR(22) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD16D9BAE7927C74 ON access_users (email)');
        $this->addSql('CREATE TABLE access_google_identities (id VARCHAR(22) NOT NULL, user_id VARCHAR(22) NOT NULL, google_id VARCHAR(25) NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, given_name VARCHAR(255) NOT NULL, family_name VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A12BAC676F5C865 ON access_google_identities (google_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A12BAC6E7927C74 ON access_google_identities (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A12BAC6A76ED395 ON access_google_identities (user_id)');
        $this->addSql('CREATE TABLE system_request_log_details (id VARCHAR(22) NOT NULL, request_log_id VARCHAR(22) NOT NULL, path TEXT NOT NULL, meta TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4F124CF4A13E9E7D ON system_request_log_details (request_log_id)');
        $this->addSql('CREATE TABLE system_request_logs (id VARCHAR(22) NOT NULL, member_id VARCHAR(22) DEFAULT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, finished_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, type VARCHAR(50) NOT NULL, "group" VARCHAR(255) NOT NULL, mili_seconds INT NOT NULL, successfull BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9C1BC9AB7597D3FE ON system_request_logs (member_id)');
        $this->addSql('COMMENT ON COLUMN system_request_logs.started_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN system_request_logs.finished_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE accounting_journal_moves ADD CONSTRAINT FK_C68D82A7597D3FE FOREIGN KEY (member_id) REFERENCES parking_members (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE accounting_journal_moves ADD CONSTRAINT FK_C68D82A478E8802 FOREIGN KEY (journal_id) REFERENCES accounting_journals (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE accounting_journals ADD CONSTRAINT FK_AB267833478E8802 FOREIGN KEY (journal_id) REFERENCES accounting_tasks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parking_member_needs ADD CONSTRAINT FK_899A921E7597D3FE FOREIGN KEY (member_id) REFERENCES parking_members (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parking_memberships ADD CONSTRAINT FK_DAF589A27597D3FE FOREIGN KEY (member_id) REFERENCES parking_members (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parking_reservations ADD CONSTRAINT FK_81AF1B3A7597D3FE FOREIGN KEY (member_id) REFERENCES parking_members (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parking_members ADD CONSTRAINT FK_CB4A2A25A76ED395 FOREIGN KEY (user_id) REFERENCES access_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE access_slack_identities ADD CONSTRAINT FK_5B43A04A76ED395 FOREIGN KEY (user_id) REFERENCES access_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE access_google_identities ADD CONSTRAINT FK_A12BAC6A76ED395 FOREIGN KEY (user_id) REFERENCES access_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE system_request_log_details ADD CONSTRAINT FK_4F124CF4A13E9E7D FOREIGN KEY (request_log_id) REFERENCES system_request_logs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE system_request_logs ADD CONSTRAINT FK_9C1BC9AB7597D3FE FOREIGN KEY (member_id) REFERENCES parking_members (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE accounting_journals DROP CONSTRAINT FK_AB267833478E8802');
        $this->addSql('ALTER TABLE accounting_journal_moves DROP CONSTRAINT FK_C68D82A478E8802');
        $this->addSql('ALTER TABLE accounting_journal_moves DROP CONSTRAINT FK_C68D82A7597D3FE');
        $this->addSql('ALTER TABLE parking_member_needs DROP CONSTRAINT FK_899A921E7597D3FE');
        $this->addSql('ALTER TABLE parking_memberships DROP CONSTRAINT FK_DAF589A27597D3FE');
        $this->addSql('ALTER TABLE parking_reservations DROP CONSTRAINT FK_81AF1B3A7597D3FE');
        $this->addSql('ALTER TABLE system_request_logs DROP CONSTRAINT FK_9C1BC9AB7597D3FE');
        $this->addSql('ALTER TABLE parking_members DROP CONSTRAINT FK_CB4A2A25A76ED395');
        $this->addSql('ALTER TABLE access_slack_identities DROP CONSTRAINT FK_5B43A04A76ED395');
        $this->addSql('ALTER TABLE access_google_identities DROP CONSTRAINT FK_A12BAC6A76ED395');
        $this->addSql('ALTER TABLE system_request_log_details DROP CONSTRAINT FK_4F124CF4A13E9E7D');
        $this->addSql('DROP TABLE accounting_journal_moves');
        $this->addSql('DROP TABLE accounting_tasks');
        $this->addSql('DROP TABLE accounting_journals');
        $this->addSql('DROP TABLE parking_availabilities');
        $this->addSql('DROP TABLE parking_member_needs');
        $this->addSql('DROP TABLE parking_memberships');
        $this->addSql('DROP TABLE parking_reservations');
        $this->addSql('DROP TABLE parking_members');
        $this->addSql('DROP TABLE parking_availability_breaks');
        $this->addSql('DROP TABLE access_slack_identities');
        $this->addSql('DROP TABLE access_users');
        $this->addSql('DROP TABLE access_google_identities');
        $this->addSql('DROP TABLE system_request_log_details');
        $this->addSql('DROP TABLE system_request_logs');
    }
}
