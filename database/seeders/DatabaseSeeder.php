<?php
namespace Database\Seeders;

namespace Database\Seeders;

// use App\Materialreq;
// use App\Quotation;
// use Illuminate\Database\Seeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AssortmentSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(ConsumptionSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(DivisiSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(FabriccompostSeeder::class);
        $this->call(FabricconstructSeeder::class);
        $this->call(MarkerdescSeeder::class);
        $this->call(MarkerfabricSeeder::class);
        $this->call(MarkerSeeder::class);
        $this->call(MaterialDetailSeeder::class);
        $this->call(MaterialreqSeeder::class);
        $this->call(PerusahaanSeeder::class);
        $this->call(QuotationSeeder::class);
        $this->call(RemarkSeeder::class);
        $this->call(RemarktypeSeeder::class);
        $this->call(SalesorderSeeder::class);
        $this->call(SalessampleSeeder::class);
        $this->call(SizespecSeeder::class);
        $this->call(SizesSeeder::class);
        $this->call(StyleSampleSeeder::class);
        $this->call(StyleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UnitSeeder::class);
    }
}
