<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180515095110 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fonctionnalite (id INT AUTO_INCREMENT NOT NULL, projet_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, priorite INT DEFAULT NULL, INDEX IDX_8F83CB48C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, nombre_participants INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, groupe_id INT NOT NULL, nom VARCHAR(255) NOT NULL, id_image INT DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, INDEX IDX_50159CA97A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, user_story_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, etat TINYINT(1) NOT NULL, description VARCHAR(255) DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, INDEX IDX_938720754AD0A436 (user_story_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_story (id INT AUTO_INCREMENT NOT NULL, fonctionnalite_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, echeance DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_994FF604477C5D8 (fonctionnalite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_groupe (utilisateur_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_6514B6AAFB88E14F (utilisateur_id), INDEX IDX_6514B6AA7A45358C (groupe_id), PRIMARY KEY(utilisateur_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fonctionnalite ADD CONSTRAINT FK_8F83CB48C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA97A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720754AD0A436 FOREIGN KEY (user_story_id) REFERENCES user_story (id)');
        $this->addSql('ALTER TABLE user_story ADD CONSTRAINT FK_994FF604477C5D8 FOREIGN KEY (fonctionnalite_id) REFERENCES fonctionnalite (id)');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AA7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_story DROP FOREIGN KEY FK_994FF604477C5D8');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA97A45358C');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AA7A45358C');
        $this->addSql('ALTER TABLE fonctionnalite DROP FOREIGN KEY FK_8F83CB48C18272');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_938720754AD0A436');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AAFB88E14F');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, mail VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE fonctionnalite');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE user_story');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_groupe');
    }
}
