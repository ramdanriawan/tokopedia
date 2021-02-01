<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user')->delete();
        
        \DB::table('user')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin 01',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$agZD9uPAphsJw5YzMrlGJO9a8O5bcggcxPTK1NzmXqEmfVFVz6TBC',
            ),
        ));
        
        
    }
}