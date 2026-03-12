<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Проверка, является ли пользователь администратором
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Проверка, является ли пользователь менеджером
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Проверка, является ли пользователь кладовщиком
     */
    public function isStorekeeper(): bool
    {
        return $this->role === 'storekeeper';
    }

    /**
     * Проверка, является ли пользователь аналитиком
     */
    public function isAnalyst(): bool
    {
        return $this->role === 'analyst';
    }

    /**
     * Проверка, является ли пользователь бухгалтером
     */
    public function isAccountant(): bool
    {
        return $this->role === 'accountant';
    }

    /**
     * Получение названия роли на русском
     */
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Администратор',
            'manager' => 'Менеджер',
            'storekeeper' => 'Кладовщик',
            'analyst' => 'Аналитик',
            'accountant' => 'Бухгалтер',
            default => 'Пользователь'
        };
    }

    /**
     * Получение доступных разделов для пользователя
     */
    public function getAvailableSectionsAttribute(): array
    {
        $sections = [];

        // Дашборд доступен всем
        $sections['dashboard'] = ['name' => 'Дашборд', 'icon' => 'tachometer-alt', 'route' => 'dashboard'];

        switch($this->role) {
            case 'admin':
                $sections['products'] = ['name' => 'Товары', 'icon' => 'box', 'route' => 'products.index'];
                $sections['categories'] = ['name' => 'Категории', 'icon' => 'tags', 'route' => 'categories.index'];
                $sections['suppliers'] = ['name' => 'Поставщики', 'icon' => 'truck', 'route' => 'suppliers.index'];
                $sections['customers'] = ['name' => 'Клиенты', 'icon' => 'users', 'route' => 'customers.index'];
                $sections['warehouse'] = ['name' => 'Ячейки склада', 'icon' => 'warehouse', 'route' => 'warehouse-cells.index'];
                $sections['incoming'] = ['name' => 'Приход', 'icon' => 'truck-loading', 'route' => 'incoming-invoices.index'];
                $sections['outgoing'] = ['name' => 'Расход', 'icon' => 'shopping-cart', 'route' => 'outgoing-orders.index'];
                $sections['inventory'] = ['name' => 'Инвентаризация', 'icon' => 'clipboard-list', 'route' => 'inventory.index'];
                $sections['reports'] = ['name' => 'Отчеты', 'icon' => 'chart-bar', 'route' => 'reports.stock'];
                $sections['users'] = ['name' => 'Пользователи', 'icon' => 'user-cog', 'route' => 'users.index'];
                break;
                
            case 'manager':
                $sections['products'] = ['name' => 'Товары', 'icon' => 'box', 'route' => 'products.index'];
                $sections['customers'] = ['name' => 'Клиенты', 'icon' => 'users', 'route' => 'customers.index'];
                $sections['outgoing'] = ['name' => 'Продажи', 'icon' => 'shopping-cart', 'route' => 'outgoing-orders.index'];
                $sections['reports'] = ['name' => 'Отчеты по продажам', 'icon' => 'chart-line', 'route' => 'reports.sales'];
                break;
                
            case 'storekeeper':
                $sections['products'] = ['name' => 'Товары', 'icon' => 'box', 'route' => 'products.index'];
                $sections['warehouse'] = ['name' => 'Ячейки склада', 'icon' => 'warehouse', 'route' => 'warehouse-cells.index'];
                $sections['incoming'] = ['name' => 'Приемка', 'icon' => 'truck-loading', 'route' => 'incoming-invoices.index'];
                $sections['outgoing'] = ['name' => 'Отгрузка', 'icon' => 'shipping-fast', 'route' => 'outgoing-orders.index'];
                $sections['inventory'] = ['name' => 'Инвентаризация', 'icon' => 'clipboard-list', 'route' => 'inventory.index'];
                $sections['reports'] = ['name' => 'Отчеты по складу', 'icon' => 'chart-bar', 'route' => 'reports.stock'];
                break;
                
            case 'analyst':
                $sections['products'] = ['name' => 'Товары', 'icon' => 'box', 'route' => 'products.index'];
                $sections['reports'] = ['name' => 'Аналитические отчеты', 'icon' => 'chart-pie', 'route' => 'reports.stock'];
                break;
                
            case 'accountant':
                $sections['products'] = ['name' => 'Товары', 'icon' => 'box', 'route' => 'products.index'];
                $sections['incoming'] = ['name' => 'Поступления', 'icon' => 'truck', 'route' => 'incoming-invoices.index'];
                $sections['outgoing'] = ['name' => 'Реализация', 'icon' => 'shopping-cart', 'route' => 'outgoing-orders.index'];
                $sections['reports'] = ['name' => 'Финансовые отчеты', 'icon' => 'chart-line', 'route' => 'reports.financial'];
                break;
        }

        return $sections;
    }

    public function incomingInvoices()
    {
        return $this->hasMany(IncomingInvoice::class);
    }

    public function outgoingOrders()
    {
        return $this->hasMany(OutgoingOrder::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}