<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221004205139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sub_categorie_article (sub_categorie_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_1FA0F32EABA7A01B (sub_categorie_id), INDEX IDX_1FA0F32E7294869C (article_id), PRIMARY KEY(sub_categorie_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sub_categorie_article ADD CONSTRAINT FK_1FA0F32EABA7A01B FOREIGN KEY (sub_categorie_id) REFERENCES sub_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_categorie_article ADD CONSTRAINT FK_1FA0F32E7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_categorie_article DROP FOREIGN KEY FK_1FA0F32EABA7A01B');
        $this->addSql('ALTER TABLE sub_categorie_article DROP FOREIGN KEY FK_1FA0F32E7294869C');
        $this->addSql('DROP TABLE sub_categorie_article');
    }
}
