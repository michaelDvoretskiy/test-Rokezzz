<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120101524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE viewed_work_app (id INT AUTO_INCREMENT NOT NULL, work_app_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_10B6940BD27EE70F (work_app_id), UNIQUE INDEX viewed_work_app_unique (user_id, work_app_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE viewed_work_app ADD CONSTRAINT FK_10B6940BD27EE70F FOREIGN KEY (work_app_id) REFERENCES work_application (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE viewed_work_app DROP FOREIGN KEY FK_10B6940BD27EE70F');
        $this->addSql('DROP TABLE viewed_work_app');
    }
}
