<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeQuestion extends Model
{
    use HasFactory;

    protected $table = 'coffee_questions';

    protected $fillable = [
        'code',
        'question',
        'input_type',
        'options',
        'order',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function conditions()
    {
        return $this->hasMany(CoffeeRuleCondition::class, 'question_code', 'code');
    }

    public function getOptionLabel(string $value): string
    {
        if (is_array($this->options)) {
            foreach ($this->options as $opt) {
                if (($opt['value'] ?? '') === $value) {
                    return $opt['label'] ?? $value;
                }
            }
        }
        return $value;
    }
}
