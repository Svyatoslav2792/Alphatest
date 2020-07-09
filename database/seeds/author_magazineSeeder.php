<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class author_magazineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('author_magazine')->delete();
        DB::table('author_magazine')->insert(['author_id' => '1', 'magazine_id' => 1]);
        DB::table('author_magazine')->insert(['author_id' => '1', 'magazine_id' => 2]);
        DB::table('author_magazine')->insert(['author_id' => '1', 'magazine_id' => 3]);
        DB::table('author_magazine')->insert(['author_id' => '2', 'magazine_id' => 1]);
        DB::table('author_magazine')->insert(['author_id' => '3', 'magazine_id' => 1]);
        DB::table('author_magazine')->insert(['author_id' => '6', 'magazine_id' => 3]);
        DB::table('author_magazine')->insert(['author_id' => '4', 'magazine_id' => 3]);
        DB::table('author_magazine')->insert(['author_id' => '2', 'magazine_id' => 2]);
    }
}
