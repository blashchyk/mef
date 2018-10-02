<?php

use yii\db\Migration;

class m160510_073922_slider_init extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%slider}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(null),
            'name' => $this->string(100)->notNull(),
            'image' => $this->string()->notNull(),
            'description' => $this->text()->defaultValue(null),
            'video_url' => $this->string()->defaultValue(null),
            'forward_url' => $this->string()->defaultValue(null),
            'type' => $this->boolean()->notNull()->defaultValue(false),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'position' => $this->integer(1)->unsigned()->notNull()->defaultValue(0),
            'button_caption' => $this->string(100)->defaultValue(null),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'theme_id' => $this->integer()->defaultValue(2),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->batchInsert('{{%slider}}', ['id', 'user_id', 'name', 'image', 'description', 'video_url', 'forward_url', 'type', 'visible', 'position', 'button_caption', 'sorting', 'theme_id', 'created_at', 'updated_at'], [
            [2, 3, 'Web Development Company', '1472108907.jpg', '<p>Our team consists of experienced web developers, designers and managers.<br/>We are looking for new clients or ongoing relationship with new business partners !', '', '/about', 0, 1, 0, 'About us', 2, 2, 1472108907, 1472108907],
            [3, 3, 'Smart IT solutions for your challenging idea', '1472109021.jpg', '<p>Our team consists of experienced web developers, designers and managers.<br /> We are looking for new clients or ongoing relationship with new business partners!<br /> Hire dedicated team of Professional web Developers &amp; Designers and other experts from us and you can be sure that you will be always provided with the high quality and timeliness of our work.</p>', '', '/contact', 0, 1, 1, 'Contact us', 3, 2, 1472109021, 1472109021],
            [4, 3, 'We are creating great products for you!', '1472109377.jpg', '<ul class="slider-list"><li><span><i class="fa fa-check"></i>Any Complexity Websites</span></li><li><span><i class="fa fa-check"></i>Project development of any complexity</span></li><li><span><i class="fa fa-check"></i>Implementation of search engine optimization</span></li></ul>', '', '/catalog/index', 0, 1, 2, 'Check our products', 4, 2, 1472109377, 1472109347],
            [5, 3, 'Web Development Company', '1481880075.png', '<p>It is convenient to work with us, because we have integrated services. With our help you can order creating a website from scratch, as well as updating and redesigning your current resource. We offer all services, which are connected with site development from planning, designing and making-up to off-site modules and add-ins development.</p>', '', '', 0, 1, 2, '', 5, 3, 1472109377, 1472109347],
            [6, 3, 'Smart IT solutions for your challenging idea', '1481880192.jpg', '<p>Ordering a site in IT Master you get a resource that is made according to the latest standards of modern web design with the requirements of search engines and is comfortable to use.</p>', '', '', 0, 1, 2, 'Check our products', 6, 3, 1472109377, 1472109347],
            [7, 3, 'We are creating great products for you!', '1481880266.png', '<ul class="slider-list"><li><span><i class="fa fa-check"></i>Proffesional web development</span></li><li><span><i class="fa fa-check"></i>Websites support</span></li><li><span><i class="fa fa-check"></i>Hire dedicated developers</span></li><li><span><i class="fa fa-check"></i>Various web services</span></li><li><span><i class="fa fa-check"></i>Modern technologies</span></li></ul>', '', '/catalog/index', 0, 1, 2, 'Check our products', 7, 3, 1472109377, 1472109347],
        ]);

        $this->addForeignKey('fk_slider_user', '{{%slider}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_slider_theme', '{{%slider}}', 'theme_id', '{{%theme}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_slider_user', '{{%slider}}');
        $this->dropForeignKey('fk_slider_theme', '{{%slider}}');

        $this->dropTable('{{%slider}}');
    }
}
