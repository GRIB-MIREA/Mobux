<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';
    protected $fillable = [
        'telegram_id',
        'first_name',
        'last_name',
        'telegram_username',
        'image'
    ];
}
