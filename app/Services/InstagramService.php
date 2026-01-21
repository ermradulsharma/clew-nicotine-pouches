<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class InstagramService
{
    protected $accessToken;
    protected $userId;

    public function __construct()
    {
        $this->accessToken = config('services.instagram.ig_token');
        $this->userId = config('services.instagram.ig_user_id');
    }

    public function getMedia($limit = 50)
    {
        $response = Http::get("https://graph.instagram.com/{$this->userId}/media", [
            'fields' => 'id,caption,media_url,permalink,timestamp,media_type,thumbnail_url',
            'access_token' => $this->accessToken,
            'limit' => $limit
        ]);

        return $response->successful() ? $response->json()['data'] : [];
    }

    public function getAllMedia()
    {
        $allMedia = [];
        $url = "https://graph.instagram.com/{$this->userId}/media";
        $params = [
            'fields' => 'id,caption,media_url,permalink,timestamp,media_type,thumbnail_url',
            'access_token' => $this->accessToken,
            'limit' => 100,
        ];

        do {
            $response = Http::get($url, $params);

            if (!$response->successful()) {
                break;
            }

            $data = $response->json();
            $allMedia = array_merge($allMedia, $data['data']);

            $url = $data['paging']['next'] ?? null;
            $params = [];
        } while ($url);

        return $allMedia;
    }
}
