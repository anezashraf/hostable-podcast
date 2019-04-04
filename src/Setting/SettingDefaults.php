<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 03/04/19
 * Time: 18:43
 */

namespace App\Setting;

class SettingDefaults
{

    const USER_INSERTED = 'user_inserted';
    const PODCAST_INSERTED = 'podcast_inserted';
    const SETTINGS_CREATED = 'settings_created';
    const IS_ONLINE = 'is_online';
    const FACEBOOK = 'facebook';
    const TWITTER = 'twitter';
    const ITUNES = 'itunes';

    const DEFAULTS = [
        self::USER_INSERTED => [
            'default_value' => 'false',
            'type' => 'boolean',
            'editable_from_dashboard' => false
        ],

        self::SETTINGS_CREATED => [
            'default_value' => 'false',
            'type' => 'boolean',
            'editable_from_dashboard' => false,
        ],

        self::IS_ONLINE => [
            'default_value' => 'false',
            'type' => 'boolean',
            'editable_from_dashboard' => true
        ],

        self::PODCAST_INSERTED => [
            'default_value' => 'false',
            'type' => 'boolean',
            'editable_from_dashboard' => false
        ],

        self::FACEBOOK => [
            'default_value' => '',
            'type' => 'text',
            'editable_from_dashboard' => true
        ],

        self::TWITTER => [
            'default_value' => '',
            'type' => 'text',
            'editable_from_dashboard' => true
        ],

        self::ITUNES => [
            'default_value' => '',
            'type' => 'text',
            'editable_from_dashboard' => true
        ]
    ];
}
