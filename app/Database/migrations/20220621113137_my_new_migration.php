<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MyNewMigration extends AbstractMigration
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
        $exists = $this->hasTable('Users');
        $date = new DateTime("now");
        if($exists){
            $table = $this->table('Users')->drop()->save();
        }
        $table = $this->table('Users');
        $table->addColumn('name', 'string', ['limit' => 25])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('created', 'datetime',['default' => $date->format(DATE_ATOM)])
            ->create();

    }
}
