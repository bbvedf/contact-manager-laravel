<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'category',
        'notes',
    ];

    /**
     * Valores por defecto para los atributos
     *
     * @var array
     */
    protected $attributes = [
        'category' => 'personal',
    ];

    /**
     * Categorías disponibles para los contactos
     */
    public const CATEGORIES = [
        'personal' => 'Personal',
        'family' => 'Familia',
        'work' => 'Trabajo',
        'friends' => 'Amigos',
        'other' => 'Otro',
    ];
}