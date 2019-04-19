<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * feed defines one to many relationship between items and feed.
     *
     * @return BelongsTo
     */
    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }
}
