<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Только админ может просматривать пользователей
        if (auth()->user()->role !== 'admin') {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Только админ может создавать пользователей
        if (auth()->user()->role !== 'admin') {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Только админ может создавать пользователей
        if (auth()->user()->role !== 'admin') {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,manager,storekeeper,analyst,accountant',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Пользователь успешно создан.');
    }

    public function edit(User $user)
    {
        // Только админ может редактировать пользователей
        if (auth()->user()->role !== 'admin') {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Только админ может редактировать пользователей
        if (auth()->user()->role !== 'admin') {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,manager,storekeeper,analyst,accountant',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Пользователь успешно обновлен.');
    }

    public function destroy(User $user)
    {
        // Только админ может удалять пользователей
        if (auth()->user()->role !== 'admin') {
            abort(403, 'У вас нет доступа к этому разделу.');
        }
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Вы не можете удалить самого себя.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Пользователь успешно удален.');
    }
}