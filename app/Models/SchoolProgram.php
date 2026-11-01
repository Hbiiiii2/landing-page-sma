<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SchoolProgram extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Get image URL with safe public asset fallback
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! empty($this->image)) {
            if (Str::startsWith($this->image, ['http://', 'https://'])) {
                return $this->image;
            }
            return asset('storage/' . $this->image);
        }

        return null;
    }
}
