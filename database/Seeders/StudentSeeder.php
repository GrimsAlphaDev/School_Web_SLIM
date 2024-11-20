<?php
use Phinx\Seed\AbstractSeed;
use Faker\Factory;

class StudentSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $students = $this->table('tbl_students');
        $studentData = [];
        
        // Ambil ID sekolah yang baru saja diinsert
        $schoolIds = array_column($this->fetchAll('SELECT id FROM tbl_schools'), 'id');
        
        for ($i = 0; $i < 10; $i++) {
            $studentData[] = [
                'id_school' => $faker->randomElement($schoolIds),
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        
        $students->insert($studentData)->save();
    }
}