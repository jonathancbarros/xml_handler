<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180816235329 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ship_order (id INT AUTO_INCREMENT NOT NULL, order_person_id INT NOT NULL, order_id INT NOT NULL, shipping_name VARCHAR(255) NOT NULL, shipping_address VARCHAR(255) NOT NULL, shipping_city VARCHAR(255) NOT NULL, shipping_country VARCHAR(255) NOT NULL, INDEX IDX_F450C04D9DFCC0BF (order_person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ship_order ADD CONSTRAINT FK_F450C04D9DFCC0BF FOREIGN KEY (order_person_id) REFERENCES person (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ship_order');
    }
}
