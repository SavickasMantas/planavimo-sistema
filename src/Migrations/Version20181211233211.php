<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181211233211 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users_to_event DROP FOREIGN KEY FK_4BD3104D43DFAB55');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7245150FE');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_type');
        $this->addSql('DROP TABLE users_to_event');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event (fk_event_type_id INT DEFAULT NULL, ID INT AUTO_INCREMENT NOT NULL, title VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, time TIME DEFAULT NULL, event_date DATE NOT NULL, UNIQUE INDEX ID_UNIQUE (ID), INDEX FK_EVENT_TYPE_ID_idx (fk_event_type_id), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_type (ID INT AUTO_INCREMENT NOT NULL, type VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX ID_UNIQUE (ID), UNIQUE INDEX type_UNIQUE (type), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_to_event (fk_user_id INT NOT NULL, fk_event_id INT NOT NULL, ID INT AUTO_INCREMENT NOT NULL, UNIQUE INDEX ID_UNIQUE (ID), INDEX FK_USER_idx (fk_user_id), INDEX fk_EVENT_ID_idx (fk_event_id), PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7245150FE FOREIGN KEY (fk_event_type_id) REFERENCES event_type (ID)');
        $this->addSql('ALTER TABLE users_to_event ADD CONSTRAINT FK_4BD3104D43DFAB55 FOREIGN KEY (fk_event_id) REFERENCES event (ID)');
        $this->addSql('ALTER TABLE users_to_event ADD CONSTRAINT FK_4BD3104D5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (ID)');
    }
}
