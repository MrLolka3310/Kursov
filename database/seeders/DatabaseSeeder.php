<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $storekeeperRole = Role::firstOrCreate(['name' => 'storekeeper']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);

        // Users
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'storekeeper@example.com'],
            [
                'name' => 'Storekeeper User',
                'password' => Hash::make('password'),
                'role_id' => $storekeeperRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'role_id' => $managerRole->id,
            ]
        );

        // Categories
        $categories = [
            ['name' => 'Электроника'],
            ['name' => 'Канцтовары'],
            ['name' => 'Продукты питания'],
            ['name' => 'Бытовая химия'],
            ['name' => 'Строительные материалы'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }

        // Warehouses
        $warehouses = [
            ['name' => 'Основной склад', 'address' => 'г. Москва, ул. Ленина, 1'],
            ['name' => 'Склад на юге', 'address' => 'г. Москва, ул. Южная, 15'],
            ['name' => 'Склад на севере', 'address' => 'г. Москва, ул. Северная, 25'],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::firstOrCreate($warehouse);
        }

        // Suppliers
        $suppliers = [
            ['name' => 'ООО "Поставщик 1"', 'phone' => '+7 (495) 123-45-67', 'email' => 'supplier1@example.com'],
            ['name' => 'ООО "Поставщик 2"', 'phone' => '+7 (495) 234-56-78', 'email' => 'supplier2@example.com'],
            ['name' => 'ИП "Поставщик 3"', 'phone' => '+7 (495) 345-67-89', 'email' => 'supplier3@example.com'],
            ['name' => 'ЗАО "Поставщик 4"', 'phone' => '+7 (495) 456-78-90', 'email' => 'supplier4@example.com'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate($supplier);
        }

        // Products
        $products = [
            // Электроника (category 1)
            ['name' => 'Ноутбук ASUS', 'sku' => 'ELEC-001', 'category_id' => 1, 'price' => 45000.00, 'unit' => 'шт'],
            ['name' => 'Монитор Samsung 24"', 'sku' => 'ELEC-002', 'category_id' => 1, 'price' => 15000.00, 'unit' => 'шт'],
            ['name' => 'Клавиатура Logitech', 'sku' => 'ELEC-003', 'category_id' => 1, 'price' => 2500.00, 'unit' => 'шт'],
            ['name' => 'Мышь беспроводная', 'sku' => 'ELEC-004', 'category_id' => 1, 'price' => 1200.00, 'unit' => 'шт'],
            
            // Канцтовары (category 2)
            ['name' => 'Бумага А4 (500 листов)', 'sku' => 'OFF-001', 'category_id' => 2, 'price' => 350.00, 'unit' => 'пачка'],
            ['name' => 'Ручки шариковые (10 шт)', 'sku' => 'OFF-002', 'category_id' => 2, 'price' => 150.00, 'unit' => 'набор'],
            ['name' => 'Папка-скоросшиватель', 'sku' => 'OFF-003', 'category_id' => 2, 'price' => 25.00, 'unit' => 'шт'],
            ['name' => 'Степлер', 'sku' => 'OFF-004', 'category_id' => 2, 'price' => 180.00, 'unit' => 'шт'],
            
            // Продукты питания (category 3)
            ['name' => 'Чай черный (100 пакетиков)', 'sku' => 'FOOD-001', 'category_id' => 3, 'price' => 200.00, 'unit' => 'пачка'],
            ['name' => 'Кофе растворимый (200 г)', 'sku' => 'FOOD-002', 'category_id' => 3, 'price' => 450.00, 'unit' => 'банка'],
            ['name' => 'Печенье (500 г)', 'sku' => 'FOOD-003', 'category_id' => 3, 'price' => 180.00, 'unit' => 'пачка'],
            ['name' => 'Вода питьевая (5 л)', 'sku' => 'FOOD-004', 'category_id' => 3, 'price' => 80.00, 'unit' => 'бутылка'],
            
            // Бытовая химия (category 4)
            ['name' => 'Средство для мытья посуды (500 мл)', 'sku' => 'CHEM-001', 'category_id' => 4, 'price' => 150.00, 'unit' => 'бутылка'],
            ['name' => 'Стиральный порошок (3 кг)', 'sku' => 'CHEM-002', 'category_id' => 4, 'price' => 450.00, 'unit' => 'пачка'],
            ['name' => 'Мыло хозяйственное (72%)', 'sku' => 'CHEM-003', 'category_id' => 4, 'price' => 50.00, 'unit' => 'кусок'],
            
            // Строительные материалы (category 5)
            ['name' => 'Шурупы (100 шт)', 'sku' => 'BUILD-001', 'category_id' => 5, 'price' => 120.00, 'unit' => 'упаковка'],
            ['name' => 'Гвозди (1 кг)', 'sku' => 'BUILD-002', 'category_id' => 5, 'price' => 150.00, 'unit' => 'кг'],
            ['name' => 'Краска водоэмульсионная (10 л)', 'sku' => 'BUILD-003', 'category_id' => 5, 'price' => 2500.00, 'unit' => 'ведро'],
            ['name' => 'Кисть малярная', 'sku' => 'BUILD-004', 'category_id' => 5, 'price' => 180.00, 'unit' => 'шт'],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['sku' => $product['sku']],
                $product
            );
        }

        // Stocks - create initial stock for each warehouse-product combination
        $warehouses = Warehouse::all();
        $products = Product::all();

        foreach ($warehouses as $warehouse) {
            foreach ($products as $product) {
                // Create random initial stock between 10 and 100
                Stock::firstOrCreate(
                    [
                        'warehouse_id' => $warehouse->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'quantity' => rand(10, 100),
                    ]
                );
            }
        }
    }
}
