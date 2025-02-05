<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title', 
        'description', 
        'start_date', 
        'end_date'
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function expenses()
    {
        return $this->hasMany(ProjectExpense::class, 'project_id');
    }

    public function donations()
    {
        return $this->hasMany(ProjectDonation::class, 'project_id');
    }
}