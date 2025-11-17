<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContactsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Contact::orderBy('name')->get();
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
            'Fecha Actualización'
        ];
    }

    public function map($contact): array
    {
        return [
            $contact->name,
            $contact->email ?? '',
            $contact->phone ?? '',
            $this->getCategoryLabel($contact->category),
            $contact->notes ?? '',
            $contact->created_at->format('d/m/Y H:i'),
            $contact->updated_at->format('d/m/Y H:i'),
        ];
    }

    private function getCategoryLabel($category)
    {
        $categories = [
            'personal' => 'Personal',
            'familia' => 'Familia',
            'trabajo' => 'Trabajo',
            'amigos' => 'Amigos', 
            'otro' => 'Otro'
        ];

        return $categories[$category] ?? $category;
    }
}