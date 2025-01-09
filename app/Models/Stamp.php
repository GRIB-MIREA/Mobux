<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    use HasFactory;

    protected $table = 'stamps';
    protected $guarded = false;

    public function cards()
    {
        return $this->belongsToMany(Card::class, 'card_stamps', 'card_id', 'stamp_id');
    }
}
