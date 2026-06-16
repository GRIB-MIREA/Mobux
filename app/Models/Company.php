<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $guarded = [];

    protected $casts = [
        'last_parser_run_id' => 'integer',
        'first_seen_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'raw_payload' => 'array',
    ];

    public function lastParserRun(): BelongsTo
    {
        return $this->belongsTo(CompanyParserRun::class, 'last_parser_run_id');
    }

    public function scopeWithoutWebsite(Builder $query): Builder
    {
        return $query->where(static function (Builder $builder): void {
            $builder->whereNull('website')
                ->orWhere('website', '');
        });
    }
}
