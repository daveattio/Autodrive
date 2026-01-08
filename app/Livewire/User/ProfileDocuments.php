<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use App\Models\User;

class ProfileDocuments extends Component
{
    use WithFileUploads;

    public User $user;
    public $client_type;

    // --- INFOS PERSONNELLES ---
    public $name, $email, $phone, $address, $city;
    public $license_number, $passport_number, $origin_country, $company_name, $company_id;

    // --- FICHIERS ---
    public $license_file;
    public $passport_file;
    public $company_doc_file;

    public function mount()
    {
        $this->user = Auth::user();
        $this->client_type = $this->user->client_type;

        // Pré-remplissage des champs textes
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->address = $this->user->address;
        $this->city = $this->user->city;
        $this->license_number = $this->user->license_number;
        $this->passport_number = $this->user->passport_number;
        $this->origin_country = $this->user->origin_country;
        $this->company_name = $this->user->company_name;
        $this->company_id = $this->user->company_id;
    }

    // 1. SAUVEGARDER LES INFOS (Texte)
    public function updateInfo()
    {
        // Validation dynamique selon le profil
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
        ];

        if ($this->client_type == 'particulier') {
            $rules['license_number'] = 'required';
        } elseif ($this->client_type == 'entreprise') {
            $rules['company_name'] = 'required';
            $rules['company_id'] = 'required';
        } elseif ($this->client_type == 'touriste') {
            $rules['passport_number'] = 'required';
            $rules['origin_country'] = 'required';
        }

        $this->validate($rules);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'license_number' => $this->license_number,
            'passport_number' => $this->passport_number,
            'origin_country' => $this->origin_country,
            'company_name' => $this->company_name,
            'company_id' => $this->company_id,
        ]);

        session()->flash('info_message', 'Informations mises à jour !');
    }

    // 2. SAUVEGARDER LES DOCUMENTS (Fichiers)
    public function saveDocuments()
    {
        $this->validate([
            'license_file' => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'passport_file' => 'nullable|file|mimes:jpg,png,pdf|max:5120',
            'company_doc_file' => 'nullable|file|mimes:jpg,png,pdf|max:5120',
        ]);

        if ($this->license_file) {
            if($this->user->license_path) Storage::disk('public')->delete($this->user->license_path);
            $this->user->update(['license_path' => $this->license_file->store('documents/licenses', 'public')]);
        }

        if ($this->passport_file && $this->client_type === 'touriste') {
             if($this->user->passport_path) Storage::disk('public')->delete($this->user->passport_path);
            $this->user->update(['passport_path' => $this->passport_file->store('documents/passports', 'public')]);
        }

        if ($this->company_doc_file && $this->client_type === 'entreprise') {
             if($this->user->company_doc_path) Storage::disk('public')->delete($this->user->company_doc_path);
            $this->user->update(['company_doc_path' => $this->company_doc_file->store('documents/companies', 'public')]);
        }

        $this->reset(['license_file', 'passport_file', 'company_doc_file']);

        return redirect()->route('user.bookings')->with('message', 'Dossier mis à jour.Attendez la validation par le Service !.');
    }

    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.user.profile-documents');
    }
}
