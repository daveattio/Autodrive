<div class="bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-blue-600">Envoyez-nous un message</h2>

    <!-- Message de succès -->
    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded animate-pulse">
            <p class="font-bold">Succès</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form wire:submit.prevent="submitMessage">
        <!-- Nom -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nom complet</label>
            <input wire:model="name" type="text" class="w-full border-gray-300 border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Votre nom">
            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input wire:model="email" type="email" class="w-full border-gray-300 border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="votre@email.com">
            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- Message -->
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Message</label>
            <textarea wire:model="message" class="w-full border-gray-300 border p-3 rounded-lg h-32 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Comment pouvons-nous vous aider ?"></textarea>
            @error('message') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- Bouton avec état de chargement -->
        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 shadow-md flex justify-center items-center">
            <span wire:loading.remove>Envoyer le message</span>
            <span wire:loading>Envoi en cours...</span>
        </button>
    </form>
</div>