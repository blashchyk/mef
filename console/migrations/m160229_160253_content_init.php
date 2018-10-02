<?php

use yii\db\Migration;

class m160229_160253_content_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'user_id' => $this->integer()->defaultValue(null),
            'link_name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->unique()->notNull(),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'title' => $this->string(100)->defaultValue(null),
            'meta_keywords' => $this->string(100)->defaultValue(null),
            'meta_description' => $this->string(100)->defaultValue(null),
            'header' => $this->string(100)->defaultValue(null),
            'content' => $this->text()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%page_category}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(null),
            'name' => $this->string(100)->notNull(),
            'slug' => $this->string(100)->unique()->notNull(),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'created_at' => $this->integer()->defaultValue(null),
            'updated_at' => $this->integer()->defaultValue(null),
        ], $tableOptions);

        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(1)->unsigned()->notNull()->defaultValue(0),
            'name' => $this->string(100)->notNull(),
            'code' => $this->string(100)->notNull(),
        ], $tableOptions);

        $this->createTable('{{%menu_item}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->defaultValue(null),
            'page_id' => $this->integer()->defaultValue(null),
            'type' => $this->integer(1)->unsigned()->notNull()->defaultValue(0),
            'link_name' => $this->string(100)->defaultValue(null),
            'url' => $this->string()->defaultValue(null),
            'sorting' => $this->integer(4)->unsigned()->defaultValue(null),
            'inherited' => $this->boolean()->notNull()->defaultValue(true),
        ], $tableOptions);

        $this->batchInsert('{{%page}}', ['id', 'parent_id', 'user_id', 'link_name', 'slug', 'sorting', 'visible', 'title', 'meta_keywords', 'meta_description', 'header', 'content', 'created_at', 'updated_at'], [
            [1, null, 1, 'Main', 'index', 1, 1, '', '', '', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', 1458210079, 1458210079],
            [2, null, 1, 'Company', 'company', 2, 1, '', '', '', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', 1458210079, 1458210079],
            [3, null, 1, 'About Us', 'about', 3, 1, '', '', '', '', '<div class="row">\r\n  <div class="col-sm-12">\r\n    <p class="lead text-red">Web development company.</p>\r\n    <p>\r\n      Our team consists of experienced web developers, designers and managers. We are looking for new clients or ongoing relationship with new business partners! Hire dedicated team of Professional web Developers & Designers and other experts from us and you can be sure that you will be always provided with the high quality and timeliness of our work.\r\n    </p>\r\n    <br /><br />\r\n  </div>\r\n</div>\r\n<div class="row">\r\n  <div class="col-sm-6">\r\n    <div class="embed-responsive embed-responsive-16by9">\r\n      <iframe src="//player.vimeo.com/video/67449472?title=0&amp;byline=0&amp;portrait=0" width="500" height="281" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>\r\n    </div>\r\n  </div>\r\n  <div class="col-sm-6">\r\n    <p class="well">\r\n      Our team consists of experienced web developers, designers and managers.\r\n    </p>\r\n    <ul class="ft-list">\r\n      <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n      <li>Donec vel nisi sit amet mauris dapibus aliquam quis vel magna.</li>\r\n      <li>Donec vulputate tellus quis volutpat congue.</li>\r\n      <li>Sed ultrices eros eu euismod semper.</li>\r\n      <li>Integer vulputate mauris in eleifend laoreet.</li>\r\n      <li>Donec vulputate tellus quis volutpat congue.</li>\r\n      <li>Sed ultrices eros eu euismod semper.</li>\r\n    </ul>\r\n  </div>\r\n</div>', 1458210079, 1457704314],
            [4, null, 1, 'Projects', 'project', 4, 1, '', '', '', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', 1458210079, 1458210079],
            [5, null, 1, 'Documents', 'document', 5, 1, '', '', '', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', 1458210079, 1458210386],
            [6, null, 1, 'Audio', 'audio', 6, 1, '', '', '', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', 1458210079, 1458210079],
            [7, null, 1, 'Video', 'video', 7, 1, '', '', '', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', 1458210079, 1458210079],
            [8, null, 1, 'Articles', 'articles', 8, 1, '', '', '', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', 1458210079, 1458210079],
            [9, null, 1, 'Archive', 'archive', 9, 1, '', '', '', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', 1458210079, 1458210079],
            [10, null, 1, 'Contacts', 'contact', 10, 1, '', '', '', '', '', 1458210079, 1458210079],
            [11, null, 1, 'Signup', 'auth/signup', 11, 3, '', '', '', '', '', 1458210079, 1458210079],
            [12, null, 1, 'Reset Password', 'auth/request-password-reset', 12, 3, '', '', '', '', '', 1458210079, 1458210079],
            [13, null, 1, 'Reset Password', 'auth/reset-password', 13, 1, '', '', '', '', '', 1458210079, 1458210079],
            [14, null, 1, 'Login', 'auth/login', 14, 3, '', '', '', '', '', 1458210079, 1458210079],
            [15, null, 1, 'Logout', 'auth/logout', 15, 2, '', '', '', '', '', 1458210079, 1458210079],
            [16, null, 1, 'My Profile', 'user/profile', 16, 2, '', '', '', '', '', 1458210079, 1458210079],
            [17, null, 1, 'Edit Profile', 'user/edit-profile', 17, 2, '', '', '', '', '', 1458210079, 1458210079],
            [18, null, 1, 'Social Accounts', 'user/social', 18, 2, '', '', '', '', '', 1458210079, 1458210079],
            [19, null, 1, 'Blog', 'blog/index', 19, 1, '', '', '', '', '', 1458210079, 1458210079],
            [20, null, 1, 'Blog Post', 'blog/post', 20, 1, '', '', '', '', '', 1458210079, 1458210079],
            [21, null, 1, 'Gallery', 'gallery/index', 21, 1, '', '', '', '', '', 1458210079, 1458210079],
            [22, null, 1, 'Faq', 'faq/index', 22, 1, '', '', '', '', '', 1458210106, 1458210106],
            [23, null, 1, 'Catalog', 'catalog/index', 23, 1, '', '', '', '', '', 1458210123, 1458210123],
            [24, null, 1, 'Product', 'catalog/product', 24, 1, '', '', '', '', '', 1458210170, 1458210170],
            [25, null, 1, 'Orders', 'order/index', 25, 1, '', '', '', '', '', 1458210170, 1458210170],
            [26, null, 1, 'Cart', 'order/cart', 26, 1, '', '', '', '', '', 1458210170, 1458210170],
            [27, null, 1, 'Checkout', 'order/checkout', 27, 1, '', '', '', '', '', 1458210170, 1458210170],
            [28, null, 1, 'Thank You', 'order/thank', 28, 1, '', '', '', '', "<p>You have successfully completed your order.</p>\r\n\r\n<p>Our team will contact you as soon as possible.</p>", 1458210170, 1458210170],
            [29, null, 1, 'Cancel Order', 'order/cancel', 29, 1, '', '', '', '', '<p>You have canceled your order.</p>', 1458210170, 1458210170],
        ]);

        $this->batchInsert('{{%menu}}', ['id', 'type', 'name', 'code'], [
            [1, 1, 'Main', 'main'],
            [2, 0, 'Info', 'info'],
            [3, 0, 'Quick Links', 'quick-links'],
            [4, 0, 'Content Links', 'content-links'],
        ]);

        $this->batchInsert('{{%menu_item}}', ['id', 'menu_id', 'parent_id', 'page_id', 'type', 'link_name', 'url', 'sorting', 'inherited'], [
            [4, 1, null, 1, 0, 'Main', '', 1, 1],
            [5, 1, null, 2, 0, 'Company', '', 2, 1],
            [6, 1, 5, 3, 0, 'About Us', '', 1, 1],
            [7, 1, 5, 4, 0, 'Projects', '', 2, 1],
            [13, 1, null, 10, 0, 'Contacts', '', 7, 1],
            [14, 2, null, 2, 0, 'Company', '', 1, 1],
            [15, 2, 14, 3, 0, 'About Us', '', 1, 1],
            [16, 2, 14, 4, 0, 'Projects', '', 2, 1],
            [17, 2, null, 5, 0, 'Documents', '', 2, 1],
            [18, 2, 17, 6, 0, 'Audio', '', 1, 1],
            [19, 2, 17, 7, 0, 'Video', '', 2, 1],
            [20, 2, 17, 8, 0, 'Articles', '', 3, 1],
            [21, 2, 17, 9, 0, 'Archive', '', 4, 1],
            [27, 2, null, 11, 0, 'Signup', '', 3, 1],
            [28, 1, null, 11, 0, 'Signup', '', 8, 1],
            [29, 1, null, 14, 0, 'Login', '', 9, 1],
//            [30, 1, null, 16, 0, 'My profile', '', 10, 1],
            [31, 1, null, 15, 0, 'Logout', '', 11, 1],
//            [32, 1, 30, 16, 0, 'My Profile', '', 1, 1],
//            [33, 1, 30, 17, 0, 'Edit Profile', '', 2, 1],
            [34, 1, 27, 13, 0, 'Reset Password', '', 3, 1],
            [35, 1, 27, 18, 0, 'Social Accounts', '', 4, 1],
            [36, 1, null, 25, 0, 'Orders', '', 5, 1],
            [37, 1, null, 19, 0, 'Blog', '', 3, 1],
            [38, 1, null, 21, 0, 'Gallery', '', 4, 1],
            [39, 1, null, 22, 0, 'Faq', '', 6, 1],
            [40, 1, null, 23, 0, 'Catalog', '', 5, 1],
            [41, 1, null, 26, 0, 'Cart', '', 6, 1],
            [42, 3, null, 1, 0, 'Main', '', 1, 1],
            [43, 3, null, 3, 0, 'About Us', '', 2, 1],
            [44, 3, null, 4, 0, 'Projects', '', 3, 1],
            [45, 3, null, 10, 0, 'Contacts', '', 4, 1],
            [46, 4, null, 19, 0, 'Blog', '', 1, 1],
            [47, 4, null, 21, 0, 'Gallery', '', 2, 1],
            [48, 4, null, 22, 0, 'Faq', '', 3, 1],
            [49, 4, null, 23, 0, 'Catalog', '', 4, 1],
        ]);

        $this->addForeignKey('fk_page_page_category', '{{%page}}', 'parent_id', '{{%page_category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_page_user', '{{%page}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');

        $this->addForeignKey('fk_page_category_user', '{{%page_category}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');

        $this->addForeignKey('fk_menu_item_menu', '{{%menu_item}}', 'menu_id', '{{%menu}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_menu_item_menu_item', '{{%menu_item}}', 'parent_id', '{{%menu_item}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_menu_item_page', '{{%menu_item}}', 'page_id', '{{%page}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_menu_item_page', '{{%menu_item}}');
        $this->dropForeignKey('fk_menu_item_menu_item', '{{%menu_item}}');
        $this->dropForeignKey('fk_menu_item_menu', '{{%menu_item}}');
        $this->dropForeignKey('fk_page_category_user', '{{%page_category}}');
        $this->dropForeignKey('fk_page_user', '{{%page}}');
        $this->dropForeignKey('fk_page_page_category', '{{%page}}');

        $this->dropTable('{{%menu_item}}');
        $this->dropTable('{{%menu}}');
        $this->dropTable('{{%page_category}}');
        $this->dropTable('{{%page}}');
    }
}
