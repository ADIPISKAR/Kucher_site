<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeliVK extends Model
{
    use HasFactory;

    protected $table = 'modeli_vks';
    protected $fillable = ['text'];
}
