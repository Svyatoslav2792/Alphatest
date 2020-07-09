<?php

use Illuminate\Database\Seeder;
use App\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Author::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Author::create([
            'surname' => 'Иванов',
            'name' => 'Иван',
            'middlename' => 'Иванович',
        ]);
        Author::create([
            'surname' => 'Иванов',
            'name' => 'Сергей',
            'middlename' => '',
        ]);
        Author::create([
            'surname' => 'Сидоров',
            'name' => 'Олег',
            'middlename' => '',
        ]);
        Author::create([
            'surname' => 'Михайлов',
            'name' => 'Артур',
            'middlename' => 'Григорьевич',
        ]);
        Author::create([
            'surname' => 'Силиванских',
            'name' => 'Аврелий',
            'middlename' => '',
        ]);
        Author::create([
            'surname' => 'Хплопов',
            'name' => 'Смерд',
            'middlename' => 'Царевич',
        ]);
    }
}
