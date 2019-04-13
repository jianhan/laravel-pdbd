<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'fetch_frequency' => 'integer',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Mutator for url attribute, if feed_root_url is not set, then set the same
     * as url when the url is set.
     *
     * @param [type] $value
     * @return void
     */
    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
        if (!isset($this->attributes['feed_root_url']) || $this->attributes['feed_root_url'] == '') {
            $this->attributes['feed_root_url'] = $value;
        }
    }

    /**
     * feeds defines one to many relationship between source and feed.
     *
     * @return HasMany
     */
    public function feeds(): HasMany
    {
        return $this->hasMany(Feed::class);
    }
}
