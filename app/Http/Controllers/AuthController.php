<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'balance' => 1000.0,
        ]);

        // Отправляем приветственное письмо (ошибка не повлияет на сохранение)
        try {
            Mail::to($user->email)->send(new WelcomeEmail($user));
        } catch (\Exception $e) {
            // Логируем ошибку, но не прерываем регистрацию
            \Log::error('Ошибка отправки email: ' . $e->getMessage());
        }

        return redirect()->route('login')->with('success', 'Регистрация успешна! Проверьте почту.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->intended('/')->with('success', 'Вы вошли в систему!');
        }

        return back()->withErrors(['email' => 'Неверные данные входа']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Вы вышли из системы');
    }
}
