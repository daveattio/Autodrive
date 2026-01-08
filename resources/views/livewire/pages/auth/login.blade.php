<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="mt-4"> <!-- Marge top pour se décoller du logo -->

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black text-slate-900">Bienvenue</h2>
        <p class="text-slate-500 text-sm">Connectez-vous pour gérer vos locations.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">

        <!-- Email -->
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1 ml-1">Adresse Email</label>
            <input wire:model="form.email" type="email" required autofocus
                   class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 font-medium transition"
                   placeholder="exemple@email.com">
            @error('form.email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Password (Avec Oeil AlpineJS) -->
        <div x-data="{ show: false }">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1 ml-1">Mot de passe</label>
            <div class="relative">
                <input wire:model="form.password" :type="show ? 'text' : 'password'" required
                       class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 font-medium transition"
                       placeholder="••••••••">

                <!-- Bouton Oeil -->
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600 transition cursor-pointer">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.057 10.057 0 01-1.555 3.058m-6.657-4.693l4.241 4.241" /></svg>
                </button>
            </div>
            @error('form.password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Remember Me & Forgot -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer">
                <span class="ms-2 text-xs text-slate-600">Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-bold" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Bouton Submit -->
        <button type="submit" class="w-full bg-slate-900 hover:bg-blue-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 text-sm flex justify-center items-center gap-2">
            Se connecter
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>

        <div class="text-center mt-6">
            <p class="text-xs text-slate-500">Pas encore de compte ? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">S'inscrire</a></p>
        </div>
    </form>
</div>
