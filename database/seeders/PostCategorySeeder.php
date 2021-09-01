<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_categories')->insert([
            [
                'id'        => 1,
                'lang'      => 'pl',
                'slug'      => 'aktualnosci',
                'name'      => 'Aktualności',
            ],
            [
                'id'        => 2,
                'lang'      => 'pl',
                'slug'      => 'przepisy-kulinarne',
                'name'      => 'Przepisy kulinarne',
            ],
            [
                'id'        => 3,
                'lang'      => 'pl',
                'slug'      => 'dokumenty',
                'name'      => 'Dokumenty',
            ],
            [
                'id'        => 4,
                'lang'      => 'ru',
                'slug'      => 'novosti',
                'name'      => 'Новости',
            ],
            [
                'id'        => 5,
                'lang'      => 'ru',
                'slug'      => 'recepti',
                'name'      => 'Рецепты',
            ],
            [
                'id'        => 6,
                'lang'      => 'ru',
                'slug'      => 'dokumenti',
                'name'      => 'Документы',
            ],
        ]);
    }
}
