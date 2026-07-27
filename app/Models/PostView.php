<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['post_id', 'user_id', 'ip_address', 'user_agent', 'referer', 'device_type', 'browser', 'browser_version', 'platform', 'country_code', 'region', 'city', 'timezone', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'session_duration', 'is_bot', 'is_mobile', 'extra_data', 'viewed_at'])]
class PostView extends Model
{
    /** @use HasFactory<\Database\Factories\PostViewFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'viewed_at' => 'datetime',
            'is_bot' => 'boolean',
            'is_mobile' => 'boolean',
            'extra_data' => 'array',
            'session_duration' => 'integer',
        ];
    }

    /**
     * Get the post that owns the post view.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user that owns the post view.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include authenticated post views.
     */
    #[Scope]
    protected function authenticated($query)
    {
        $query->whereNotNull('user_id');
    }

    /**
     * Scope a query to only include anonymous post views.
     */
    protected function anonymous($query)
    {
        $query->whereNull('user_id');
    }

    /**
     * Scope a query to only include not bot post views.
     */
    protected function notBot($query)
    {
        $query->where('is_bot', false);
    }

    /**
     * Scope a query to only include mobile post views.
     */
    protected function mobile($query)
    {
        $query->where('is_mobile', true);
    }

    /**
     * Scope a query to only include desktop post views.
     */
    protected function desktop($query)
    {
        $query->where('is_mobile', false);
    }

    /**
     * Scope a query to only include by country post views.
     */
    protected function byCountry($query, string $countryCode)
    {
        $query->where('country_code', $countryCode);
    }

    /**
     * Scope a query to only include with utm post views.
     */
    protected function withUtm($query)
    {
        $query->whereNotNull('utm_source');
    }
}
