<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ImageMetaData extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table = 'image_metadata';
    public $timestamps  = true;
    protected $fillable = [
        'u_id','emis_code','category_type', 'lat', 'long', 'accuracy'
    ];
    public function images(): HasMany
    {
        return $this->hasMany(Images::class, 'metadata_id');
    }
}
