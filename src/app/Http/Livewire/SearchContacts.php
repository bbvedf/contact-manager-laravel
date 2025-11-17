<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class SearchContacts extends Component
{
    public $search = '';
    public $category = '';

    public function render()
    {
        $contacts = Contact::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('notes', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->where('category', $this->category);
            })
            ->orderBy('name')
            ->get();

        return view('livewire.search-contacts', [
            'contacts' => $contacts,
            'categories' => [
                '' => 'Todas las categorías',
                'personal' => 'Personal',
                'familia' => 'Familia', 
                'trabajo' => 'Trabajo',
                'amigos' => 'Amigos',
                'otro' => 'Otro'
            ]
        ]);
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->category = '';
    }
}