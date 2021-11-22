<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211122151931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player ADD gls_firstname VARCHAR(255) NOT NULL, ADD gls_lastname VARCHAR(255) NOT NULL, ADD gls_email VARCHAR(255) NOT NULL, ADD gls_identifier VARCHAR(255) NOT NULL, ADD gls_pseudo VARCHAR(255) NOT NULL, ADD gls_creation DATETIME NOT NULL, ADD gls_modification DATETIME NOT NULL, DROP firstname, DROP lastname, DROP email, DROP identifier, DROP pseudo, DROP creation, DROP modification, CHANGE mirian gls_mirian INT DEFAULT NULL');
        $this->addSql('ALTER TABLE characters ADD gls_name VARCHAR(16) NOT NULL, ADD gls_caste VARCHAR(16) DEFAULT NULL, ADD gls_knowledge VARCHAR(16) DEFAULT NULL, ADD gls_intelligence INT DEFAULT NULL, ADD gls_life INT DEFAULT NULL, ADD gls_kind VARCHAR(16) NOT NULL, DROP name, DROP caste, DROP knowledge, DROP intelligence, DROP life, DROP kind, CHANGE surname gls_surname VARCHAR(64) NOT NULL, CHANGE image gls_image VARCHAR(128) DEFAULT NULL, CHANGE creation gls_creation DATETIME NOT NULL, CHANGE identifier gls_identifier VARCHAR(40) NOT NULL, CHANGE modification gls_modification DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD name VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD caste VARCHAR(16) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD knowledge VARCHAR(16) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD intelligence INT DEFAULT NULL, ADD life INT DEFAULT NULL, ADD kind VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP gls_name, DROP gls_caste, DROP gls_knowledge, DROP gls_intelligence, DROP gls_life, DROP gls_kind, CHANGE gls_surname surname VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_image image VARCHAR(128) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_creation creation DATETIME NOT NULL, CHANGE gls_identifier identifier VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_modification modification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Player ADD firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD identifier VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD pseudo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD creation DATETIME NOT NULL, ADD modification DATETIME NOT NULL, DROP gls_firstname, DROP gls_lastname, DROP gls_email, DROP gls_identifier, DROP gls_pseudo, DROP gls_creation, DROP gls_modification, CHANGE gls_mirian mirian INT DEFAULT NULL');
    }
}
