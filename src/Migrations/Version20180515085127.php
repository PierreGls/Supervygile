<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180515085127 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_story ADD fonctionnalite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_story ADD CONSTRAINT FK_994FF604477C5D8 FOREIGN KEY (fonctionnalite_id) REFERENCES fonctionnalite (id)');
        $this->addSql('CREATE INDEX IDX_994FF604477C5D8 ON user_story (fonctionnalite_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_story DROP FOREIGN KEY FK_994FF604477C5D8');
        $this->addSql('DROP INDEX IDX_994FF604477C5D8 ON user_story');
        $this->addSql('ALTER TABLE user_story DROP fonctionnalite_id');
    }
}
