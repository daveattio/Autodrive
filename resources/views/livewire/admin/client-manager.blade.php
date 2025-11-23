<div class="p-6 bg-white border-b border-gray-200">
    <h2 class="text-xl font-bold mb-4">Liste des Clients</h2>
    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100">
                <th class="py-2 px-4 border">Nom</th>
                <th class="py-2 px-4 border">Email</th>
                <th class="py-2 px-4 border">Inscrit le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-t">
                <td class="py-2 px-4">{{ $user->name }}</td>
                <td class="py-2 px-4">{{ $user->email }}</td>
                <td class="py-2 px-4">{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>