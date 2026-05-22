<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'url', 'page_title', 'route_name', 'session_id',
        'ip_address', 'user_agent', 'browser', 'browser_version',
        'os', 'device_type', 'referrer', 'country',
        'time_on_page', 'is_bounce',
    ];

    protected $casts = [
        'is_bounce' => 'boolean',
    ];

    /**
     * Parse a User-Agent string into browser name + version.
     */
    public static function parseBrowser(string $ua): array
    {
        $browser = 'Unknown';
        $version = '';

        $patterns = [
            'Edge'    => '/Edg\/([\d.]+)/',
            'Chrome'  => '/Chrome\/([\d.]+)/',
            'Firefox' => '/Firefox\/([\d.]+)/',
            'Safari'  => '/Version\/([\d.]+).*Safari/',
            'Opera'   => '/OPR\/([\d.]+)/',
            'IE'      => '/MSIE ([\d.]+)|Trident.*rv:([\d.]+)/',
        ];

        foreach ($patterns as $name => $pattern) {
            if (preg_match($pattern, $ua, $m)) {
                $browser = $name;
                $version = $m[1] ?? $m[2] ?? '';
                break;
            }
        }

        return ['browser' => $browser, 'version' => $version];
    }

    /**
     * Parse OS from User-Agent.
     */
    public static function parseOS(string $ua): string
    {
        return match (true) {
            str_contains($ua, 'Windows NT 10') => 'Windows 10/11',
            str_contains($ua, 'Windows NT 6.3') => 'Windows 8.1',
            str_contains($ua, 'Windows')        => 'Windows',
            str_contains($ua, 'Mac OS X')       => 'macOS',
            str_contains($ua, 'iPhone')         => 'iOS (iPhone)',
            str_contains($ua, 'iPad')           => 'iPadOS',
            str_contains($ua, 'Android')        => 'Android',
            str_contains($ua, 'Linux')          => 'Linux',
            default                             => 'Other',
        };
    }

    /**
     * Detect device type from User-Agent.
     */
    public static function parseDevice(string $ua): string
    {
        if (str_contains($ua, 'Mobi') || str_contains($ua, 'Android') && !str_contains($ua, 'Tablet')) {
            return 'Mobile';
        }
        if (str_contains($ua, 'iPad') || str_contains($ua, 'Tablet')) {
            return 'Tablet';
        }
        return 'Desktop';
    }

    /**
     * Anonymise IP by removing the last octet.
     */
    public static function anonymiseIp(string $ip): string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return substr($ip, 0, strrpos($ip, ':') + 1) . '0';
        }
        $parts = explode('.', $ip);
        array_pop($parts);
        return implode('.', $parts) . '.0';
    }
}
