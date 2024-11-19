<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordsExclusion extends Model
{
    use HasFactory;

    protected $table = 'words_exclusion';

    protected $fillable = ['word'];

    public $timestamps = true; 
}
