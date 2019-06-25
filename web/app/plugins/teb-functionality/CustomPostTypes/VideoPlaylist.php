<?php

namespace TFD\CPT;

class VideoPlaylist extends CPT
{
    protected static $args = [
        'rewrite' => [
            'permastruct' => '/video/playlist/%postname%/',
        ],
    ];

    public static function getArgs()
    {
        $args = parent::getArgs();
        return array_merge($args, self::$args);
    }

    public static function getNames()
    {
        return [
            'singular' => esc_html__('Video Playlist', TEXT_DOMAIN_BACKEND),
            'plural' => esc_html__('Video Playlists', TEXT_DOMAIN_BACKEND),
        ];
    }
}

return new VideoPlaylist();
