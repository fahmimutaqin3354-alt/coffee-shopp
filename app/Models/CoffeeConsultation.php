<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeConsultation extends Model
{
    use HasFactory;

    protected $table = 'coffee_consultations';

    protected $fillable = [
        'user_id',
        'session_id',
        'answers',
        'result_summary',
    ];

    protected $casts = [
        'answers' => 'array',
        'result_summary' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
