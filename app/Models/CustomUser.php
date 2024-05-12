<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sobrenome',
        'cep',
        'cidade',
        'uf',
        'endereco',
        'numero',
        'bairro',
    ];
}
