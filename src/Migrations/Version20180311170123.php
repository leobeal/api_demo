<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180311170123 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, discount INT DEFAULT NULL, type VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_E1E0B40E4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_order (product_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_5475E8C44584665A (product_id), INDEX IDX_5475E8C48D9F6D38 (order_id), PRIMARY KEY(product_id, order_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_shopping_cart (product_id INT NOT NULL, shopping_cart_id INT NOT NULL, INDEX IDX_A847C8044584665A (product_id), INDEX IDX_A847C80445F80CD (shopping_cart_id), PRIMARY KEY(product_id, shopping_cart_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bundles (parent_id INT NOT NULL, children_id INT NOT NULL, INDEX IDX_D8A73A98727ACA70 (parent_id), INDEX IDX_D8A73A983D3D2749 (children_id), PRIMARY KEY(parent_id, children_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, price NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E52FFDEEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, api_key VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649C912ED9D (api_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_72AAD4F6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discount ADD CONSTRAINT FK_E1E0B40E4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C44584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C48D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_shopping_cart ADD CONSTRAINT FK_A847C8044584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_shopping_cart ADD CONSTRAINT FK_A847C80445F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bundles ADD CONSTRAINT FK_D8A73A98727ACA70 FOREIGN KEY (parent_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE bundles ADD CONSTRAINT FK_D8A73A983D3D2749 FOREIGN KEY (children_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE shopping_cart ADD CONSTRAINT FK_72AAD4F6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE discount DROP FOREIGN KEY FK_E1E0B40E4584665A');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C44584665A');
        $this->addSql('ALTER TABLE product_shopping_cart DROP FOREIGN KEY FK_A847C8044584665A');
        $this->addSql('ALTER TABLE bundles DROP FOREIGN KEY FK_D8A73A98727ACA70');
        $this->addSql('ALTER TABLE bundles DROP FOREIGN KEY FK_D8A73A983D3D2749');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C48D9F6D38');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE shopping_cart DROP FOREIGN KEY FK_72AAD4F6A76ED395');
        $this->addSql('ALTER TABLE product_shopping_cart DROP FOREIGN KEY FK_A847C80445F80CD');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_order');
        $this->addSql('DROP TABLE product_shopping_cart');
        $this->addSql('DROP TABLE bundles');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE shopping_cart');
    }
}
