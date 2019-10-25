<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191024200214 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

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
        $this->addSql('ALTER TABLE system_request_logs RENAME COLUMN "group" TO base_path');
        $this->addSql('ALTER TABLE system_request_logs ADD CONSTRAINT FK_9C1BC9AB7597D3FE FOREIGN KEY (member_id) REFERENCES parking_members (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE system_request_logs DROP CONSTRAINT FK_9C1BC9AB7597D3FE');
        $this->addSql('ALTER TABLE system_request_logs RENAME COLUMN base_path TO "group"');
        $this->addSql('ALTER TABLE parking_member_needs DROP CONSTRAINT FK_899A921E7597D3FE');
        $this->addSql('ALTER TABLE parking_reservations DROP CONSTRAINT FK_81AF1B3A7597D3FE');
        $this->addSql('ALTER TABLE access_slack_identities DROP CONSTRAINT FK_5B43A04A76ED395');
        $this->addSql('ALTER TABLE parking_members DROP CONSTRAINT FK_CB4A2A25A76ED395');
        $this->addSql('ALTER TABLE access_google_identities DROP CONSTRAINT FK_A12BAC6A76ED395');
        $this->addSql('ALTER TABLE accounting_journal_moves DROP CONSTRAINT FK_C68D82A7597D3FE');
        $this->addSql('ALTER TABLE accounting_journal_moves DROP CONSTRAINT FK_C68D82A478E8802');
        $this->addSql('ALTER TABLE parking_memberships DROP CONSTRAINT FK_DAF589A27597D3FE');
        $this->addSql('ALTER TABLE accounting_journals DROP CONSTRAINT FK_AB267833478E8802');
        $this->addSql('ALTER TABLE system_request_log_details DROP CONSTRAINT FK_4F124CF4A13E9E7D');
    }
}
