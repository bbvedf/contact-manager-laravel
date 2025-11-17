<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'category',
        'notes',
    ];

    protected $attributes = [
        'category' => 'personal',
    ];

    /**
     * Categorías disponibles para los contactos
     */
    public const CATEGORIES = [
        'personal' => 'Personal',
        'familia' => 'Familia',
        'trabajo' => 'Trabajo', 
        'amigos' => 'Amigos',
        'otro' => 'Otro',
    ];
}