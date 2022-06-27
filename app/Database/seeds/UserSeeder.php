<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $users = $this->table('Users');
        $column = $users->hasColumn('name');
        $data = [
            [
                'name'    => 'johny',
                'password' => password_hash('johndoe',PASSWORD_BCRYPT),
            ],[
                'name'    => 'admin',
                'password' => password_hash('admin',PASSWORD_BCRYPT),
            ],[
                'name'    => 'normaluser',
                'password' => password_hash('passw0rd',PASSWORD_BCRYPT),
            ],[
                'name'    => 'test',
                'password' => password_hash('test',PASSWORD_BCRYPT),
            ]
        ];
        if (!$column) {
            $users->insert($data)->saveData();
        }
        else{
            $users->truncate();
            $users->insert($data)->saveData();
        }

    }

}
