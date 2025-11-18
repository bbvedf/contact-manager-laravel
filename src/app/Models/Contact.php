<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone', 
        'category',
        'notes',
    ];

    protected $attributes = [
        'category' => 'personal',
    ];

    /**
     * Accesor para nombre completo
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

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