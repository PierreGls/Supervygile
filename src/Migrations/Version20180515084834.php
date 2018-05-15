<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180515084834 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fonctionnalite ADD projet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fonctionnalite ADD CONSTRAINT FK_8F83CB48C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_8F83CB48C18272 ON fonctionnalite (projet_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fonctionnalite DROP FOREIGN KEY FK_8F83CB48C18272');
        $this->addSql('DROP INDEX IDX_8F83CB48C18272 ON fonctionnalite');
        $this->addSql('ALTER TABLE fonctionnalite DROP projet_id');
    }
}
