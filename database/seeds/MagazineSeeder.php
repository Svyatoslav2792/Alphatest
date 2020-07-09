<?php

use Illuminate\Database\Seeder;
use App\Magazine;

class MagazineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Magazine::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Magazine::create([
            'title' => 'Первый',
            'description' => 'Первый журнал',
            'image' => 'LEpwl8j7fQ.jpg',
        ]);
        Magazine::create([
            'title' => 'Второй',
            'description' => 'второй журнал',
            'image' => 'Безымянный.png',
        ]);
        Magazine::create([
            'title' => 'Пустой',
            'description' => '',
            'image' => '',
        ]);
        Magazine::create([
            'title' => 'Old school magazine',
            'description' => 'Old good strings',
            'image' => '12.png',
        ]);

    }
}
