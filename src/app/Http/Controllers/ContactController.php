<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::orderBy('last_name')->get();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'category' => 'required|string|in:personal,familia,trabajo,amigos,otro',
            'notes' => 'nullable|string|max:500',
        ]);

        Contact::create($request->all());

        return redirect()->route('contacts.index')
            ->with('success', 'Contacto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        // Guardar de dónde venimos (excepto si venimos de editar esta misma página)
        $previous = url()->previous();
        if (!Str::contains($previous, ["/contacts/{$contact->id}/edit", "/contacts/{$contact->id}"])) {
            session(['contact_origin' => $previous]);
        }
        
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        // Guardar de dónde venimos (excepto si venimos de ver esta misma página)
        $previous = url()->previous();
        if (!Str::contains($previous, ["/contacts/{$contact->id}", "/contacts/{$contact->id}/edit"])) {
            session(['contact_origin' => $previous]);
        }
        
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|string|max:20',
            'category'   => 'required|in:personal,familia,trabajo,amigos,otro',
            'notes'      => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        // Subida de avatar
if ($request->hasFile('profile_picture')) {
    // Borrar el anterior si existe
    if ($contact->profile_picture) {
        Storage::disk('public')->delete('profiles/' . $contact->profile_picture);
    }

    $file = $request->file('profile_picture');
    $filename = $contact->id . '_' . time() . '.' . $file->getClientOriginalExtension();
    
    // GUARDAR EN profiles/ (sin el 'public/' delante)
    $file->storeAs('profiles', $filename, 'public');
    
    $validated['profile_picture'] = $filename;
}

        $contact->update($validated);

        return redirect()->route('contacts.show', $contact)
                         ->with('success', 'Contacto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contacto eliminado correctamente.');
    }

    /**
     * Exportar contactos a Excel
     */
    public function exportExcel()
    {
        return Excel::download(new ContactsExport, 'contactos-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Exportar contactos a PDF
     */
    public function exportPdf()
    {
        $contacts = Contact::orderBy('name')->get();
        
        $pdf = PDF::loadView('contacts.pdf', compact('contacts'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif']);
        
        return $pdf->download('contactos-' . date('Y-m-d') . '.pdf');
    }
}