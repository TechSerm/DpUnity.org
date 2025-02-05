<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'color'
    ];

    public function projectExpenses()
    {
        return $this->hasMany(ProjectExpense::class, 'expense_category_id');
    }

    public function getNameAttribute()
    {
        return $this->title;
    }
}