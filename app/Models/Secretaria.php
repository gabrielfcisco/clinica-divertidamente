<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretaria extends Model
{
    use HasFactory;

    protected $table = "secretarias";

    protected $fillable = [
        'Nome',
        'Sobrenome',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
