<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButterflyVk extends Model
{
    use HasFactory;

    // Указываем имя таблицы, если оно не совпадает с именем модели во множественном числе
    protected $table = 'butterfly_vk';

    // Указываем столбцы, которые могут быть массово заполнены
    protected $fillable = ['message'];

    // Если у вас есть временные метки (created_at и updated_at), Laravel будет их обрабатывать автоматически.
    public $timestamps = true;
}
