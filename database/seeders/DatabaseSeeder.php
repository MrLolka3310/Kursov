<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\WarehouseCell;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создание пользователей
        // Администратор
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        // Менеджер
        User::create([
            'name' => 'Иванов Петр (Менеджер)',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);
        
        // Кладовщик
        User::create([
            'name' => 'Сидоров Иван (Кладовщик)',
            'email' => 'storekeeper@example.com',
            'password' => Hash::make('password'),
            'role' => 'storekeeper',
        ]);
        
        // Аналитик
        User::create([
            'name' => 'Петрова Анна (Аналитик)',
            'email' => 'analyst@example.com',
            'password' => Hash::make('password'),
            'role' => 'analyst',
        ]);
        
        // Бухгалтер
        User::create([
            'name' => 'Смирнова Елена (Бухгалтер)',
            'email' => 'accountant@example.com',
            'password' => Hash::make('password'),
            'role' => 'accountant',
        ]);

        // Создание категорий
        $electronics = Category::create([
            'name' => 'Электроника',
            'slug' => 'electronics',
            'description' => 'Товары электронной категории',
        ]);
        
        $computers = Category::create([
            'name' => 'Компьютеры',
            'parent_id' => $electronics->id,
            'slug' => 'computers',
            'description' => 'Компьютеры и комплектующие',
        ]);
        
        $laptops = Category::create([
            'name' => 'Ноутбуки',
            'parent_id' => $computers->id,
            'slug' => 'laptops',
            'description' => 'Портативные компьютеры',
        ]);

        // Создание товаров
        Product::create([
            'sku' => 'LAP-001',
            'name' => 'Ноутбук Asus ROG',
            'description' => 'Игровой ноутбук',
            'category_id' => $laptops->id,
            'unit' => 'шт',
            'purchase_price' => 80000,
            'selling_price' => 95000,
            'min_stock' => 2,
            'max_stock' => 20,
        ]);
        
        Product::create([
            'sku' => 'LAP-002',
            'name' => 'Ноутбук Dell XPS',
            'description' => 'Профессиональный ноутбук',
            'category_id' => $laptops->id,
            'unit' => 'шт',
            'purchase_price' => 90000,
            'selling_price' => 105000,
            'min_stock' => 2,
            'max_stock' => 15,
        ]);

        // Создание поставщиков
        Supplier::create([
            'name' => 'ООО "ТехноПоставка"',
            'contact_person' => 'Сидоров Сидор',
            'phone' => '+7 (495) 123-45-67',
            'email' => 'info@techpost.ru',
            'address' => 'г. Москва, ул. Техническая, д. 10',
            'inn' => '7701234567',
            'kpp' => '770101001',
            'ogrn' => '1234567890123',
        ]);

        // Создание клиентов
        Customer::create([
            'name' => 'ООО "Ромашка"',
            'contact_person' => 'Иванова Мария',
            'phone' => '+7 (495) 765-43-21',
            'email' => 'info@romashka.ru',
            'address' => 'г. Москва, ул. Цветочная, д. 5',
            'inn' => '7707654321',
            'customer_type' => 'legal',
            'discount' => 5,
        ]);

        // Создание ячеек склада
        WarehouseCell::create([
            'code' => 'A-01-01',
            'zone' => 'A',
            'rack' => '01',
            'shelf' => '01',
            'description' => 'Стеллаж A, полка 1, ячейка 1',
            'max_weight' => 100,
            'is_active' => true,
        ]);
        
        WarehouseCell::create([
            'code' => 'A-01-02',
            'zone' => 'A',
            'rack' => '01',
            'shelf' => '01',
            'description' => 'Стеллаж A, полка 1, ячейка 2',
            'max_weight' => 100,
            'is_active' => true,
        ]);
        
    }
}