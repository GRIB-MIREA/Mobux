<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailingHistory extends Model
{
    use HasFactory;

    protected $table = 'mailing_history';
    protected $guarded = false;
}
