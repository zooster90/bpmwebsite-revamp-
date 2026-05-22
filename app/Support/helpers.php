<?php

if (! function_exists('cdn_rewrite')) {
    /**
     * Rewrite a Spatie /storage/... URL (or any path containing /storage/)
     * so it points at the configured object-storage CDN (IMAGE_CDN_URL).
     *
     * - Returns null/empty unchanged.
     * - If no CDN configured, returns the URL unchanged.
     * - Otherwise: strip everything up to and including "/storage/" and
     *   prepend the CDN base (so /storage/398/foo.jpg → https://cdn/398/foo.jpg).
     */
    function cdn_rewrite(?string $url): ?string
    {
        if (! $url) {
            return $url;
        }
        $cdn = config('app.image_cdn_url');
        if (! $cdn) {
            return $url;
        }
        if (preg_match('#/storage/(.+)$#', $url, $m)) {
            return rtrim($cdn, '/') . '/' . $m[1];
        }
        return $url;
    }
}
