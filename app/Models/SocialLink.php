<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    /** @use HasFactory<\Database\Factories\SocialLinkFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'photo_url',
        'status',
        'icon',
    ];

    /**
     * Get the appropriate URL for the social link.
     * If it's a phone number, returns tel: protocol, otherwise returns the original URL.
     */
    public function getContactUrl(): string
    {
        // Check if name is "Phone" (case-insensitive)
        if (strtolower($this->name) === 'phone') {
            // Clean the phone number (remove spaces, dashes, parentheses, etc.)
            $phoneNumber = preg_replace('/[^0-9+]/', '', $this->url);

            return 'tel:'.$phoneNumber;
        }

        // Check if URL looks like a phone number (contains only digits, +, spaces, dashes, parentheses)
        $cleanedUrl = trim($this->url);
        if (preg_match('/^[\d\s\-\+\(\)]+$/', $cleanedUrl) && preg_match('/\d/', $cleanedUrl)) {
            $phoneNumber = preg_replace('/[^0-9+]/', '', $cleanedUrl);

            return 'tel:'.$phoneNumber;
        }

        return $this->url;
    }

    /**
     * Check if this social link is a phone number.
     */
    public function isPhone(): bool
    {
        return strtolower($this->name) === 'phone' ||
               (preg_match('/^[\d\s\-\+\(\)]+$/', trim($this->url)) && preg_match('/\d/', $this->url));
    }
}
