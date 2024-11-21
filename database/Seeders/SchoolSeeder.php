<?php

use Phinx\Seed\AbstractSeed;
use Faker\Factory;

class SchoolSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        // Seed Schools First
        $schools = $this->table('tbl_schools');
        $schoolData = [];

        $prefix = ['SD', 'SMP', 'SMA', 'SMK'];

        for ($i = 0; $i < 1005; $i++) {
            $schoolData[] = [
                'school_name' => $prefix[rand(0, 3)] . ' ' . $faker->name,
                'address' => $faker->address,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        $schools->insert($schoolData)->save();
    }
}
