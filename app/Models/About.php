<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class About extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'subtitle'];


    public function getSubtitleAttribute($value)
    {
        return strip_tags($value);
    }
}
