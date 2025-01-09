<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;

    protected $table = 'promocodes';
    protected $guarded = false;

    public function card() {
        return $this->belongsTo(Card::class, 'card_id', 'id');
    }
}
