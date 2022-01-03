<?php

namespace MichaelRubel\SeoManager\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoTag extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tags' => AsCollection::class,
    ];

    /**
     * @return string
     */
    public function getUrlColumnName(): string
    {
        return 'url';
    }

    /**
     * @return string
     */
    public function getTagsColumnName(): string
    {
        return 'tags';
    }
}
