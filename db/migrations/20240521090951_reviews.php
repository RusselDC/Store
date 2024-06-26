<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Reviews extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('reviews');

        $table
            ->addColumn('product_id', 'integer', ['signed' => false])
            ->addColumn('user_id', 'integer', ['signed' => false])
            ->addColumn('order_id', 'integer', ['signed' => false])
            ->addColumn('rating', 'integer', ['signed' => false])
            ->addColumn('comment', 'text')
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('product_id', 'product', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->addForeignKey('order_id', 'order', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->create();
            
    }
}
