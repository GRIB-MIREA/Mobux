<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardStamp extends Model
{
    use HasFactory;

    protected $table = 'card_stamps';
    protected $guarded = false;
}
