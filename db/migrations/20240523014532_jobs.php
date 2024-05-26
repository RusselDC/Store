<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Jobs extends AbstractMigration
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
        $jobs = $this->table('jobs');
        $jobs->addColumn('job', 'text')
            ->addColumn('status', 'integer', ['default' => 0])
            ->create();
    }
}
