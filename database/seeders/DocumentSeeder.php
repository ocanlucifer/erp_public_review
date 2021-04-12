<?php
namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::insert([
            [
                'id'                => '1',
                'no_document'       => 'CM-MARK-111',
                'date'              => '2011-11-07',
                'page'              => '1',
                'revision'          => '1'
            ],
            [
                'id'                => '2',
                'no_document'       => 'CM-MARK-112',
                'date'              => '2011,11-08',
                'page'              => '1',
                'revision'          => '1'
            ]
        ]);
    }
}
