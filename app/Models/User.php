<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'users';  // Esto es para asegurarse de que está utilizando la tabla 'users'

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Los atributos que pueden ser asignados masivamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',      // Nombre del usuario
        'email',     // Correo electrónico del usuario
        'password',  // Contraseña del usuario
        'role',      // Rol del usuario (si es necesario)
    ];

    /**
     * Los atributos que deben ser ocultos para la serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',      // Para que no se muestre la contraseña en las respuestas JSON
        'remember_token', // Para ocultar el token de "recordarme"
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Esto asegura que la contraseña esté cifrada de manera adecuada.
        ];
    }

    // Si el usuario tiene muchos 'decks' (si aplica en tu caso)
    public function decks(): HasMany
    {
        return $this->hasMany(Deck::class);
    }
}
