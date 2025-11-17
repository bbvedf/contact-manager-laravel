<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Contactos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .personal { background-color: #007bff; color: white; }
        .familia { background-color: #28a745; color: white; }
        .trabajo { background-color: #6f42c1; color: white; }
        .amigos { background-color: #ffc107; color: black; }
        .otro { background-color: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Lista de Contactos</h1>
        <p>Generado el: {{ date('d/m/Y H:i') }}</p>
        <p>Total de contactos: {{ $contacts->count() }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Categoría</th>
                <th>Notas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email ?? '-' }}</td>
                <td>{{ $contact->phone ?? '-' }}</td>
                <td>
                    <span class="badge {{ $contact->category }}">
                        @switch($contact->category)
                            @case('personal') Personal @break
                            @case('familia') Familia @break
                            @case('trabajo') Trabajo @break
                            @case('amigos') Amigos @break
                            @case('otro') Otro @break
                        @endswitch
                    </span>
                </td>
                <td>{{ $contact->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>