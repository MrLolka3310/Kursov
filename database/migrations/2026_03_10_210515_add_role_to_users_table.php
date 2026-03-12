<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'admin',           // Администратор - полный доступ
                'manager',         // Менеджер - управление заказами, клиентами
                'storekeeper',     // Кладовщик - складские операции
                'analyst',         // Аналитик - только отчеты
                'accountant'       // Бухгалтер - финансовая часть
            ])->default('storekeeper')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};