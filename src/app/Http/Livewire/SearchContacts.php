<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;
use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SearchContacts extends Component
{
    public $search = '';
    public $category = '';
    public $viewMode = 'cards'; // 'cards' o 'list'

    public function render()
    {
    $contacts = Contact::query()
        ->when($this->search, function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%')
                ->orWhere('notes', 'like', '%' . $this->search . '%');
        })
        ->when($this->category, function ($query) {
            $query->where('category', $this->category);
        })
        ->orderBy('last_name')  // Primero por apellido
        ->orderBy('first_name') // Luego por nombre
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

    public function exportExcel()
    {
        $search = $this->search;
        $category = $this->category;
        
        $export = new class($search, $category) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithMapping {
            
            private $search;
            private $category;

            public function __construct($search, $category)
            {
                $this->search = $search;
                $this->category = $category;
            }

            public function collection()
            {
                $query = \App\Models\Contact::query()
                    ->when($this->search, function ($query) {
                        $query->where('first_name', 'like', '%' . $this->search . '%')
                              ->orWhere('last_name', 'like', '%' . $this->search . '%')
                              ->orWhere('email', 'like', '%' . $this->search . '%')
                              ->orWhere('phone', 'like', '%' . $this->search . '%')
                              ->orWhere('notes', 'like', '%' . $this->search . '%');
                    })
                    ->when($this->category, function ($query) {
                        $query->where('category', $this->category);
                    })
                    ->orderBy('first_name')
                    ->orderBy('last_name');

                return $query->get();
            }

            public function headings(): array
            {
                return [
                    'Nombre',
                    'Email', 
                    'Teléfono',
                    'Categoría',
                    'Notas',
                    'Fecha Creación',
                ];
            }

            public function map($contact): array
            {
                $categories = [
                    'personal' => 'Personal',
                    'familia' => 'Familia',
                    'trabajo' => 'Trabajo',
                    'amigos' => 'Amigos', 
                    'otro' => 'Otro'
                ];

                return [
                    $contact->last_name . ', ' . $contact->first_name, // Cambiado aquí
                    $contact->email ?? '',
                    $contact->phone ?? '',
                    $categories[$contact->category] ?? $contact->category,
                    $contact->notes ?? '',
                    $contact->created_at->format('d/m/Y H:i'),
                ];
            }
        };

        return Excel::download($export, 'contactos-filtrados-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf()
    {
        $contacts = $this->getFilteredContacts();
        
        $pdf = PDF::loadView('contacts.pdf', compact('contacts'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif']);
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'contactos-filtrados-' . date('Y-m-d') . '.pdf');
    }

    private function getFilteredContacts()
    {
        return Contact::query()
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('notes', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->where('category', $this->category);
            })
            ->orderBy('last_name')  // Primero por apellido
            ->orderBy('first_name') // Luego por nombre
            ->get();
    }
}