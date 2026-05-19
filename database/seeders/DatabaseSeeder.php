<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@toko.com',
            'password' => bcrypt('password'),
        ]);

        // Categories
        $cat1 = \App\Models\Category::create(['name' => 'Elektronik', 'description' => 'Barang elektronik']);
        $cat2 = \App\Models\Category::create(['name' => 'Pakaian', 'description' => 'Pakaian pria dan wanita']);
        $cat3 = \App\Models\Category::create(['name' => 'Makanan', 'description' => 'Makanan ringan dan minuman']);

        // Suppliers
        $sup1 = \App\Models\Supplier::create(['name' => 'PT Surya Elektronik', 'address' => 'Jakarta', 'contact' => '08123456789']);
        $sup2 = \App\Models\Supplier::create(['name' => 'CV Maju Jaya', 'address' => 'Bandung', 'contact' => '08987654321']);

        // Products
        \App\Models\Product::create([
            'category_id' => $cat1->id,
            'code' => 'BRG-001',
            'name' => 'Laptop Asus ROG',
            'price' => 15000000,
            'stock' => 10,
        ]);

        \App\Models\Product::create([
            'category_id' => $cat2->id,
            'code' => 'BRG-002',
            'name' => 'Kemeja Flannel',
            'price' => 150000,
            'stock' => 50,
        ]);

        \App\Models\Product::create([
            'category_id' => $cat3->id,
            'code' => 'BRG-003',
            'name' => 'Kopi Kapal Api',
            'price' => 15000,
            'stock' => 100,
        ]);
    }
}
