<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250301235234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create brands, models, cars, credit_programs and credit_requests tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE brands (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cars (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, model_id INT NOT NULL, photo VARCHAR(255) NOT NULL, price INT NOT NULL, INDEX IDX_95C71D1444F5D008 (brand_id), INDEX IDX_95C71D147975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit_programs (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, interest_rate NUMERIC(5, 1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit_requests (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, program_id INT NOT NULL, initial_payment INT NOT NULL, loan_term INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_D06E6F6FC3C6F69F (car_id), INDEX IDX_D06E6F6F3EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE models (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E4D6300944F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D1444F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D147975B7E7 FOREIGN KEY (model_id) REFERENCES models (id)');
        $this->addSql('ALTER TABLE credit_requests ADD CONSTRAINT FK_D06E6F6FC3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id)');
        $this->addSql('ALTER TABLE credit_requests ADD CONSTRAINT FK_D06E6F6F3EB8070A FOREIGN KEY (program_id) REFERENCES credit_programs (id)');
        $this->addSql('ALTER TABLE models ADD CONSTRAINT FK_E4D6300944F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D1444F5D008');
        $this->addSql('ALTER TABLE models DROP FOREIGN KEY FK_E4D6300944F5D008');
        $this->addSql('ALTER TABLE credit_requests DROP FOREIGN KEY FK_D06E6F6FC3C6F69F');
        $this->addSql('ALTER TABLE credit_requests DROP FOREIGN KEY FK_D06E6F6F3EB8070A');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D147975B7E7');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE credit_programs');
        $this->addSql('DROP TABLE credit_requests');
        $this->addSql('DROP TABLE models');
    }
}
