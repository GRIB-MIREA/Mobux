<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cards';
    protected $guarded = false;

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function stamps() {
        return $this->belongsToMany(Stamp::class, 'card_stamps', 'card_id', 'stamp_id');
    }

    public function promocodes()
    {
        return $this->hasMany(Promocode::class);
    }

    public function scopeWithPromocodes($query)
    {
        return $query->whereHas('promocodes');
    }
}
