<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function psicologo()
    {
        return $this->hasOne(Psicologo::class);
    }

    public function patients()
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

     protected function type(): Attribute
     {
         return new Attribute(
             get: fn ($value) =>  ["cliente", "psicologa", "secretaria", "administrador"][$value],
         );
     }
 
     public function cliente(){
         return $this->hasOne(Cliente::class);
     }
 
     public function psicologa(){
         return $this->hasOne(Psicologa::class);
     }

     public function secretaria(){
        return $this->hasOne(Secretaria::class);
    }

}
