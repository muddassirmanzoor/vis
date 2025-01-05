<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolVisit extends Model
{
    use HasFactory;
    protected $table = 'school_visit';
    protected $fillable = [
        'emiscode','class','subject','qty_received','useable','unuseable','head_name','head_mobile_no', 'link'
    ];
}
