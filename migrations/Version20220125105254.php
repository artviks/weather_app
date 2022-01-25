<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125105254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ipaddress (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, ip VARCHAR(45) NOT NULL, INDEX IDX_2ABB023E64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, weather_id INT DEFAULT NULL, continent_code VARCHAR(2) NOT NULL, continent_name VARCHAR(25) NOT NULL, country_code VARCHAR(2) NOT NULL, country_name VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, zip VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_5E9E89CB8CE675E (weather_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weather (id INT AUTO_INCREMENT NOT NULL, main VARCHAR(50) NOT NULL, description VARCHAR(100) NOT NULL, temperature INT NOT NULL, feels_like INT NOT NULL, pressure INT NOT NULL, humidity INT NOT NULL, wind_speed INT NOT NULL, clouds INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ipaddress ADD CONSTRAINT FK_2ABB023E64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB8CE675E FOREIGN KEY (weather_id) REFERENCES weather (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ipaddress DROP FOREIGN KEY FK_2ABB023E64D218E');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB8CE675E');
        $this->addSql('DROP TABLE ipaddress');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE weather');
    }
}
