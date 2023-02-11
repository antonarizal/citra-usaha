<?php namespace App\Database\Seeds;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
	private $table = 'user';
	private $seed_size = 33;

	public function run()
	{
        $data = [
            [
                'username'  => 'admin',
                'password'  =>  md5("admin")
            ],
            [
                'username'  => 'john',
                'password'  =>  md5("12345")
            ]
        ];
        $this->db->table('user')->insertBatch($data);

        
	}
}
