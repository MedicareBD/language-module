<?php

namespace Modules\Language\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Language\Entities\Language;

class LanguageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Language::create([
            'name' => 'English',
            'native_name' => 'English',
            'code' => 'en',
            'isDefault' => true,
            'isSystem' => true,
        ]);
    }
}
