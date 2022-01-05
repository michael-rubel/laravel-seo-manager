<?php

namespace MichaelRubel\SeoManager\Tests\Stubs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MichaelRubel\SeoManager\Contracts\SeoTagContract;

class TestModel extends Model implements SeoTagContract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'seo_tags';

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
        'tags' => 'string',
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
