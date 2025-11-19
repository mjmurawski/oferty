<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251119184941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offer_attributes (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, attribute_id INT NOT NULL, value VARCHAR(500) NOT NULL, INDEX IDX_CE12CDCA4F34D596 (offer_id), INDEX IDX_CE12CDCAB6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_photos (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, url VARCHAR(500) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9599F72C4F34D596 (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_videos (id INT AUTO_INCREMENT NOT NULL, offer_id INT NOT NULL, url VARCHAR(500) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B44573C74F34D596 (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offers (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(10, 2) DEFAULT NULL, price_negotiable TINYINT(1) NOT NULL, free TINYINT(1) NOT NULL, city VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7EC9F620A76ED395 (user_id), INDEX IDX_7EC9F62012469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blocked_users (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, blocked_user_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A3C2E415A76ED395 (user_id), INDEX IDX_A3C2E4151EBCBB63 (blocked_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_attributes (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, options JSON DEFAULT NULL, INDEX IDX_1785CE0E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversations (id INT AUTO_INCREMENT NOT NULL, user1_id INT NOT NULL, user2_id INT NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C2521BF156AE248B (user1_id), INDEX IDX_C2521BF1441B8B65 (user2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorites (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, offer_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E46960F5A76ED395 (user_id), INDEX IDX_E46960F54F34D596 (offer_id), UNIQUE INDEX user_offer_unique (user_id, offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logs (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, action VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F08FC65CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, conversation_id INT NOT NULL, sender_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DB021E969AC0396 (conversation_id), INDEX IDX_DB021E96F624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifications (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type VARCHAR(100) NOT NULL, message LONGTEXT NOT NULL, `read` TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6000B0D3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reports (id INT AUTO_INCREMENT NOT NULL, reported_user_id INT NOT NULL, reporter_id INT NOT NULL, offer_id INT DEFAULT NULL, message LONGTEXT NOT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F11FA745E7566E (reported_user_id), INDEX IDX_F11FA745E1CFE6F5 (reporter_id), INDEX IDX_F11FA7454F34D596 (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_profiles (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, avatar_url VARCHAR(500) DEFAULT NULL, bio LONGTEXT DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_6BBD6130A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_reviews (id INT AUTO_INCREMENT NOT NULL, reviewer_id INT NOT NULL, reviewed_id INT NOT NULL, rating INT NOT NULL, comment LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_317DF50570574616 (reviewer_id), INDEX IDX_317DF5055254E55 (reviewed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password_hash VARCHAR(255) NOT NULL, role VARCHAR(20) NOT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(20) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offer_attributes ADD CONSTRAINT FK_CE12CDCA4F34D596 FOREIGN KEY (offer_id) REFERENCES offers (id)');
        $this->addSql('ALTER TABLE offer_attributes ADD CONSTRAINT FK_CE12CDCAB6E62EFA FOREIGN KEY (attribute_id) REFERENCES category_attributes (id)');
        $this->addSql('ALTER TABLE offer_photos ADD CONSTRAINT FK_9599F72C4F34D596 FOREIGN KEY (offer_id) REFERENCES offers (id)');
        $this->addSql('ALTER TABLE offer_videos ADD CONSTRAINT FK_B44573C74F34D596 FOREIGN KEY (offer_id) REFERENCES offers (id)');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_7EC9F620A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_7EC9F62012469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE blocked_users ADD CONSTRAINT FK_A3C2E415A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE blocked_users ADD CONSTRAINT FK_A3C2E4151EBCBB63 FOREIGN KEY (blocked_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE category_attributes ADD CONSTRAINT FK_1785CE0E12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE conversations ADD CONSTRAINT FK_C2521BF156AE248B FOREIGN KEY (user1_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE conversations ADD CONSTRAINT FK_C2521BF1441B8B65 FOREIGN KEY (user2_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F54F34D596 FOREIGN KEY (offer_id) REFERENCES offers (id)');
        $this->addSql('ALTER TABLE logs ADD CONSTRAINT FK_F08FC65CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E969AC0396 FOREIGN KEY (conversation_id) REFERENCES conversations (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F624B39D FOREIGN KEY (sender_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745E7566E FOREIGN KEY (reported_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA7454F34D596 FOREIGN KEY (offer_id) REFERENCES offers (id)');
        $this->addSql('ALTER TABLE user_profiles ADD CONSTRAINT FK_6BBD6130A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_reviews ADD CONSTRAINT FK_317DF50570574616 FOREIGN KEY (reviewer_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_reviews ADD CONSTRAINT FK_317DF5055254E55 FOREIGN KEY (reviewed_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer_attributes DROP FOREIGN KEY FK_CE12CDCA4F34D596');
        $this->addSql('ALTER TABLE offer_attributes DROP FOREIGN KEY FK_CE12CDCAB6E62EFA');
        $this->addSql('ALTER TABLE offer_photos DROP FOREIGN KEY FK_9599F72C4F34D596');
        $this->addSql('ALTER TABLE offer_videos DROP FOREIGN KEY FK_B44573C74F34D596');
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_7EC9F620A76ED395');
        $this->addSql('ALTER TABLE offers DROP FOREIGN KEY FK_7EC9F62012469DE2');
        $this->addSql('ALTER TABLE blocked_users DROP FOREIGN KEY FK_A3C2E415A76ED395');
        $this->addSql('ALTER TABLE blocked_users DROP FOREIGN KEY FK_A3C2E4151EBCBB63');
        $this->addSql('ALTER TABLE category_attributes DROP FOREIGN KEY FK_1785CE0E12469DE2');
        $this->addSql('ALTER TABLE conversations DROP FOREIGN KEY FK_C2521BF156AE248B');
        $this->addSql('ALTER TABLE conversations DROP FOREIGN KEY FK_C2521BF1441B8B65');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5A76ED395');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F54F34D596');
        $this->addSql('ALTER TABLE logs DROP FOREIGN KEY FK_F08FC65CA76ED395');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E969AC0396');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96F624B39D');
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D3A76ED395');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745E7566E');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745E1CFE6F5');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA7454F34D596');
        $this->addSql('ALTER TABLE user_profiles DROP FOREIGN KEY FK_6BBD6130A76ED395');
        $this->addSql('ALTER TABLE user_reviews DROP FOREIGN KEY FK_317DF50570574616');
        $this->addSql('ALTER TABLE user_reviews DROP FOREIGN KEY FK_317DF5055254E55');
        $this->addSql('DROP TABLE offer_attributes');
        $this->addSql('DROP TABLE offer_photos');
        $this->addSql('DROP TABLE offer_videos');
        $this->addSql('DROP TABLE offers');
        $this->addSql('DROP TABLE blocked_users');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE category_attributes');
        $this->addSql('DROP TABLE conversations');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP TABLE logs');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE reports');
        $this->addSql('DROP TABLE user_profiles');
        $this->addSql('DROP TABLE user_reviews');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
