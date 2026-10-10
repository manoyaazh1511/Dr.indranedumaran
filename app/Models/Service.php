<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasSlug;

    public const SECTIONS = ['fertility' => 'Fertility', 'gynaecology' => 'Gynaecology', 'maternity' => 'Pregnancy & Maternity Care'];

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_published' => 'boolean', 'is_featured' => 'boolean', 'is_educational' => 'boolean'];
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class)->where('is_published', true)->orderBy('sort_order')->orderBy('id');
    }

    /** Newline-separated admin text turned into a clean list. */
    public function lines(?string $field): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $this->{$field}))));
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true)->orderBy('sort_order')->orderBy('id');
    }
}
