<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feed extends Model
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

    /*
    ..######...######...#######..########..########..######.
    .##....##.##....##.##.....##.##.....##.##.......##....##
    .##.......##.......##.....##.##.....##.##.......##......
    ..######..##.......##.....##.########..######....######.
    .......##.##.......##.....##.##........##.............##
    .##....##.##....##.##.....##.##........##.......##....##
    ..######...######...#######..##........########..######.
     */

    /**
     * scopeIsActive define a local scope for only active ones.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeIsActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * scopeNotFetchedYet return only feeds not fetched yet by frequency.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotFetchedYet(Builder $query): Builder
    {
        return $query->whereNull('last_synced_at')
            ->orWhere('fetch_frequency', '<=', 0)
            ->orWhere(function (Builder $subQuery) {
                return $subQuery->whereRaw('TIMESTAMPDIFF(MINUTE,NOW(),last_synced_at) > fetch_frequency');
            });
    }

    /*
    .########..########.##..........###....########.####..#######..##....##..######..##.....##.####.########...######.
    .##.....##.##.......##.........##.##......##.....##..##.....##.###...##.##....##.##.....##..##..##.....##.##....##
    .##.....##.##.......##........##...##.....##.....##..##.....##.####..##.##.......##.....##..##..##.....##.##......
    .########..######...##.......##.....##....##.....##..##.....##.##.##.##..######..#########..##..########...######.
    .##...##...##.......##.......#########....##.....##..##.....##.##..####.......##.##.....##..##..##..............##
    .##....##..##.......##.......##.....##....##.....##..##.....##.##...###.##....##.##.....##..##..##........##....##
    .##.....##.########.########.##.....##....##....####..#######..##....##..######..##.....##.####.##.........######.
     */

    /**
     * source defines one to many relationship between source and feed.
     *
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    /**
     * items defines one to many relationship between items and feed.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->HasMany(Item::class);
    }
}
