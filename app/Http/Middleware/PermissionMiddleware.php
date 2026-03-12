<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Права доступа для каждой роли
     */
    private $permissions = [
        'admin' => [
            'dashboard',
            'products.*',
            'categories.*',
            'suppliers.*',
            'customers.*',
            'warehouse.*',
            'invoices.*',
            'inventory.*',
            'reports.*',
            'users.*',
            'settings.*'
        ],
        'manager' => [
            'dashboard',
            'products.view',
            'customers.*',
            'invoices.outgoing.*',
            'reports.sales'
        ],
        'storekeeper' => [
            'dashboard',
            'products.view',
            'warehouse.*',
            'invoices.incoming.*',
            'inventory.*'
        ],
        'analyst' => [
            'dashboard',
            'products.view',
            'reports.*'
        ],
        'accountant' => [
            'dashboard',
            'products.view',
            'invoices.*',
            'reports.financial'
        ]
    ];

    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;
        
        // Проверяем, есть ли у роли доступ к указанному разрешению
        if (!isset($this->permissions[$userRole])) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }

        // Проверка на точное совпадение или wildcard
        foreach ($this->permissions[$userRole] as $allowedPermission) {
            if ($allowedPermission === $permission) {
                return $next($request);
            }
            
            // Проверка на wildcard (например, products.*)
            if (str_contains($allowedPermission, '*')) {
                $pattern = str_replace('*', '.*', $allowedPermission);
                if (preg_match("/^{$pattern}$/", $permission)) {
                    return $next($request);
                }
            }
        }

        abort(403, 'У вас нет прав для выполнения этого действия.');
    }
}