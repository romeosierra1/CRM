<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180625054724 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__elastic_reserved_field AS SELECT id, elastic_field_name, data_type FROM elastic_reserved_field');
        $this->addSql('DROP TABLE elastic_reserved_field');
        $this->addSql('CREATE TABLE elastic_reserved_field (id INTEGER NOT NULL, data_type VARCHAR(50) NOT NULL COLLATE BINARY, elastic_field_name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO elastic_reserved_field (id, elastic_field_name, data_type) SELECT id, elastic_field_name, data_type FROM __temp__elastic_reserved_field');
        $this->addSql('DROP TABLE __temp__elastic_reserved_field');
        $this->addSql('CREATE TEMPORARY TABLE __temp__lead_custom_field AS SELECT user_id, column_name, machine_field_name, elastic_field_name, data_type, type, config FROM lead_custom_field');
        $this->addSql('DROP TABLE lead_custom_field');
        $this->addSql('CREATE TABLE lead_custom_field (user_id VARCHAR(255) NOT NULL COLLATE BINARY, column_name VARCHAR(255) NOT NULL COLLATE BINARY, machine_field_name VARCHAR(20) NOT NULL COLLATE BINARY, data_type VARCHAR(50) NOT NULL COLLATE BINARY, type VARCHAR(100) DEFAULT NULL COLLATE BINARY, config CLOB DEFAULT NULL COLLATE BINARY, elastic_field_name VARCHAR(100) NOT NULL, PRIMARY KEY(user_id, column_name))');
        $this->addSql('INSERT INTO lead_custom_field (user_id, column_name, machine_field_name, elastic_field_name, data_type, type, config) SELECT user_id, column_name, machine_field_name, elastic_field_name, data_type, type, config FROM __temp__lead_custom_field');
        $this->addSql('DROP TABLE __temp__lead_custom_field');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__elastic_reserved_field AS SELECT id, elastic_field_name, data_type FROM elastic_reserved_field');
        $this->addSql('DROP TABLE elastic_reserved_field');
        $this->addSql('CREATE TABLE elastic_reserved_field (id INTEGER NOT NULL, data_type VARCHAR(50) NOT NULL, elastic_field_name VARCHAR(10) NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO elastic_reserved_field (id, elastic_field_name, data_type) SELECT id, elastic_field_name, data_type FROM __temp__elastic_reserved_field');
        $this->addSql('DROP TABLE __temp__elastic_reserved_field');
        $this->addSql('CREATE TEMPORARY TABLE __temp__lead_custom_field AS SELECT user_id, column_name, machine_field_name, elastic_field_name, data_type, type, config FROM lead_custom_field');
        $this->addSql('DROP TABLE lead_custom_field');
        $this->addSql('CREATE TABLE lead_custom_field (user_id VARCHAR(255) NOT NULL, column_name VARCHAR(255) NOT NULL, machine_field_name VARCHAR(20) NOT NULL, data_type VARCHAR(50) NOT NULL, type VARCHAR(100) DEFAULT NULL, config CLOB DEFAULT NULL, elastic_field_name VARCHAR(10) NOT NULL COLLATE BINARY, PRIMARY KEY(user_id, column_name))');
        $this->addSql('INSERT INTO lead_custom_field (user_id, column_name, machine_field_name, elastic_field_name, data_type, type, config) SELECT user_id, column_name, machine_field_name, elastic_field_name, data_type, type, config FROM __temp__lead_custom_field');
        $this->addSql('DROP TABLE __temp__lead_custom_field');
    }
}
