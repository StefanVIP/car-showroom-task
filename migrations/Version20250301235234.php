<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250301235234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create brand, model, car, credit_program and credit_request tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
        );
        $this->addSql(
            'CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, model_id INT NOT NULL, photo VARCHAR(255) NOT NULL, price INT NOT NULL, INDEX IDX_773DE69D44F5D008 (brand_id), INDEX IDX_773DE69D7975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
        );
        $this->addSql(
            'CREATE TABLE credit_program (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, interest_rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
        );
        $this->addSql(
            'CREATE TABLE credit_request (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, program_id INT NOT NULL, initial_payment INT NOT NULL, loan_term INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_113E8B0C3C6F69F (car_id), INDEX IDX_113E8B03EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
        );
        $this->addSql(
            'CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D79572D944F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
        );
        $this->addSql(
            'ALTER TABLE car ADD CONSTRAINT FK_773DE69D44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)',
        );
        $this->addSql(
            'ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)',
        );
        $this->addSql(
            'ALTER TABLE credit_request ADD CONSTRAINT FK_113E8B0C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)',
        );
        $this->addSql(
            'ALTER TABLE credit_request ADD CONSTRAINT FK_113E8B03EB8070A FOREIGN KEY (program_id) REFERENCES credit_program (id)',
        );
        $this->addSql(
            'ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)',
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D44F5D008');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE credit_request DROP FOREIGN KEY FK_113E8B0C3C6F69F');
        $this->addSql('ALTER TABLE credit_request DROP FOREIGN KEY FK_113E8B03EB8070A');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7975B7E7');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE credit_program');
        $this->addSql('DROP TABLE credit_request');
        $this->addSql('DROP TABLE model');
    }
}
