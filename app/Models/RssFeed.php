<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo as BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany as HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * RssFeed represents Rss feed where sources of articles come from.
 */
class RssFeed extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * parent defines a relationship in many end.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(RssFeed::class);
    }

    /**
     * children defines a relationship in the one end.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(RssFeed::class);
    }
}
