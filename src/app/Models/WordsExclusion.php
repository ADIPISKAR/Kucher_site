<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordsExclusion extends Model
{
    use HasFactory;

    // Указываем таблицу, если имя модели не совпадает с названием таблицы в БД
    protected $table = 'words_exclusion';

    // Если вы хотите разрешить массовое присваивание данных, указываем столбцы, которые можно заполнять
    protected $fillable = ['word'];

    // Если не хотите использовать timestamp поля, можно отключить их
    public $timestamps = true; // Убедитесь, что в вашей миграции есть `created_at` и `updated_at` поля
}
