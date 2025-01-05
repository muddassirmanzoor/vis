<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $table = 'support_complaints'; // Set the table name explicitly

    protected $fillable = [
        'district',
        'complaint_no',
        'pp_id',
        'school_id',
        'mpa_name',
        'issue_category',
        'issue_details',
        'issue_category_other',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'action',
         'action_remarks',
        // Add any other fields that you may have in your database
    ];


}
