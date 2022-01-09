<?php

namespace Database\Seeders;

use App\Models\PostCategory;
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
        $data = [
            [
                'lang'      => 'pl',
                'slug'      => 'aktualnosci',
                'name'      => 'Aktualności',
            ],
            [
                'lang'      => 'pl',
                'slug'      => 'przepisy-kulinarne',
                'name'      => 'Przepisy kulinarne',
            ],
            [
                'lang'      => 'pl',
                'slug'      => 'dokumenty',
                'name'      => 'Dokumenty',
            ],
            [
                'lang'      => 'ru',
                'slug'      => 'novosti',
                'name'      => 'Новости',
            ],
            [
                'lang'      => 'ru',
                'slug'      => 'recepti',
                'name'      => 'Рецепты',
            ],
            [
                'lang'      => 'ru',
                'slug'      => 'dokumenti',
                'name'      => 'Документы',
            ],
        ];

        PostCategory::insert($data);
    }
}
