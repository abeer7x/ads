<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{   
    use HasFactory;

    protected $fillable = [
    'title',
    'description',
    'price',
    'status',
    'user_id',
    'category_id',
];
    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2) . ' $';
    }

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('Y/m/d H:i');
    }
    public function setTitleAttribute($value)
{
    $this->attributes['title'] = strtolower($value);
}



    public function scopeActive($query)
{
    return $query->where('status', 'active');
}

public function scopeUserAds($query, $userId)
{
    return $query->where('user_id', $userId);
}

public function mainImage()
{
    return $this->morphOne(Image::class, 'imageable')->latestOfMany();
}

}
