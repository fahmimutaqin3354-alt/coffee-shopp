<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeRule extends Model
{
    use HasFactory;

    protected $table = 'coffee_rules';

    protected $fillable = [
        'code',
        'name',
        'description',
        'target_menu_id',
        'recommended_reason',
        'is_active',
        'priority',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    public function targetMenu()
    {
        return $this->belongsTo(Menu::class, 'target_menu_id');
    }

    public function conditions()
    {
        return $this->hasMany(CoffeeRuleCondition::class, 'rule_id');
    }
}
