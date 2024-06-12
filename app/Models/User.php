<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'cover_path',
        'avatar_path',
        'is_public'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function followRequests()
    {
        return $this->hasMany(FollowRequest::class);
    }

    public function followRequestsSent()
    {
        return $this->hasMany(FollowRequest::class, 'follower_id');
    }

    public function avatar_url()
    {
        // Verifica si el usuario tiene una ruta de avatar definida
        if ($this->avatar_path) {
            // Si hay una ruta de avatar definida, devuelve la URL completa utilizando la función asset
            return asset('storage/' . $this->avatar_path);
        } else {
            // Si no hay una ruta de avatar definida, puedes devolver una URL de avatar predeterminada o nula según tus necesidades
            // Por ejemplo, si tienes un avatar predeterminado en tu carpeta de almacenamiento público, puedes usar algo como esto:
            return asset('storage/default_avatar.png');
            // O puedes devolver null si no deseas mostrar ningún avatar predeterminado:
            // return null;
        }
    }
}
