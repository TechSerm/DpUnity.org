<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'description', 
        'amount', 
        'project_id', 
        'expense_category_id', 
        'attachment'
    ];

    protected $casts = [
        'attachment' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
}