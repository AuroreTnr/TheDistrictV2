<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250319125004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detail_commande (id INT AUTO_INCREMENT NOT NULL, ma_commande_id INT NOT NULL, nom_plat VARCHAR(255) NOT NULL, illustration_plat VARCHAR(255) NOT NULL, quantite_plat INT NOT NULL, prix_plat DOUBLE PRECISION NOT NULL, tva_plat DOUBLE PRECISION NOT NULL, INDEX IDX_98344FA69E7BDFAB (ma_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA69E7BDFAB FOREIGN KEY (ma_commande_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA69E7BDFAB');
        $this->addSql('DROP TABLE detail_commande');
    }
}
