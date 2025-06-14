<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_name',
        'store_description',
        'store_address',
        'latitude',
        'longitude',
        'store_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
