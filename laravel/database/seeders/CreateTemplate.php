<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;

class CreateTemplate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = [
            [
                'nama'=>'AYO PPPK',
                'email'=>'ayopppk@gmail.com',
                'no_hp'=>'0811111111',
                'alamat'=>'',
                'copyright'=>'Copyright By Lorem Ipsum',
                'logo_besar'=>'/image/global/logo.png',
                'logo_kecil'=>'/image/global/logo_kecil.png',
            ]
            ];
            foreach ($template as $key => $value) {
                Template::create($value);
            }
    }
}
