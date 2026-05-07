<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Fields that can be mass-assigned.
     * Ini menentukan kolom mana yang bisa diisi via create() atau update().
     */
    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    /**
     * Relationship: Task belongs to a User.
     * Setiap task dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
