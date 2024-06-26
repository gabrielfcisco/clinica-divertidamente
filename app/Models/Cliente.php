<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep',
        'cidade',
        'uf',
        'endereco',
        'numero',
        'bairro',
        'telefone',
    ];

}
