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
        'profile_picture'
    ];

    protected $casts = [
        'profile_picture' => 'string',
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

    /**
     * Generar avatar automático basado en iniciales
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->profile_picture) {
            return $this->profile_picture; // ← SOLO el nombre del archivo
        }
        
        // Fallback a iniciales (tu código existente)
        $firstName = $this->removeAccents($this->first_name);
        $lastName = $this->removeAccents($this->last_name);
        
        $initials = strtoupper(
            substr($firstName, 0, 1) . 
            substr($lastName, 0, 1)
        );

        $name = $this->first_name . ' ' . $this->last_name;
        $color = substr(md5($name), 0, 6);
        
        $svg = $this->generateInitialsAvatar($initials, $color);
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Eliminar acentos y caracteres especiales
     */
    private function removeAccents($string)
    {
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace('/&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);/i', '$1', $string);
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace('/[^a-zA-Z0-9]/', ' ', $string);
        $string = preg_replace('/\s+/', ' ', $string);
        return trim($string);
    }

    /**
     * Generar avatar SVG con iniciales
     */
    private function generateInitialsAvatar($initials, $color)
    {
        $background = '#' . $color;
        $textColor = $this->getContrastColor($background);
        
        return <<<SVG
        <svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <rect width="100" height="100" fill="$background"/>
            <text x="50" y="50" font-family="Arial, sans-serif" font-size="40" 
                fill="$textColor" text-anchor="middle" dy=".35em">
                $initials
            </text>
        </svg>
        SVG;
    }

    /**
     * Calcular color de texto contrastante (blanco o negro)
     */
    private function getContrastColor($hexColor)
    {
        // Convertir hex a RGB
        $r = hexdec(substr($hexColor, 1, 2));
        $g = hexdec(substr($hexColor, 3, 2));
        $b = hexdec(substr($hexColor, 5, 2));
        
        // Calcular luminancia
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        
        return $luminance > 0.5 ? '#000000' : '#FFFFFF';
    }

    /**
     * Obtener URL de avatar DiceBear (alternativa)
     */
    public function getDiceBearAvatarUrlAttribute()
    {
        $seed = urlencode($this->first_name . ' ' . $this->last_name);
        return "https://api.dicebear.com/7.x/initials/svg?seed=$seed&size=100&backgroundColor=039be5";
    }

}