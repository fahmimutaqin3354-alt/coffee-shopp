<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeRuleCondition extends Model
{
    use HasFactory;

    protected $table = 'coffee_rule_conditions';

    protected $fillable = [
        'rule_id',
        'question_code',
        'operator',
        'expected_value',
        'condition_group',
    ];

    public function rule()
    {
        return $this->belongsTo(CoffeeRule::class, 'rule_id');
    }

    public function question()
    {
        return $this->belongsTo(CoffeeQuestion::class, 'question_code', 'code');
    }
}
