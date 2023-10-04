<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([ 'display_name' => 'Site title',       'key' => 'site_title',        'value' => 'Bloggz',              'type' => 'text']);
        Setting::create([ 'display_name' => 'Site Slogan',      'key' => 'site_slogan',       'value' => 'Amazing blog',        'type' => 'text']);
        Setting::create([ 'display_name' => 'Site Description', 'key' => 'site_description',  'value' => 'Bloggz CMS',          'type' => 'textarea']);
        Setting::create([ 'display_name' => 'Site Keywords',    'key' => 'site_keywords',     'value' => 'Bloggz|blog|posts',   'type' => 'text',   'multiple_values' => 1]);
        Setting::create([ 'display_name' => 'Site Email',       'key' => 'site_email',        'value' => 'blogz@bloggz.test',   'type' => 'email',  'multiple_values' => 1]);
        Setting::create([ 'display_name' => 'Site Status',      'key' => 'site_status',       'value' => 'Active',              'type' => 'text']);
        Setting::create([ 'display_name' => 'Admin Title',      'key' => 'admin_title',       'value' => 'Bloggz System',       'type' => 'text']);
        Setting::create([ 'display_name' => 'Phone Number',     'key' => 'phone_number',      'value' => '0937475740',          'type' => 'number', 'multiple_values' => 1]);
        Setting::create([ 'display_name' => 'Address',          'key' => 'address',           'value' => 'Tartus',              'type' => 'text']);
        Setting::create([ 'display_name' => 'Map Latitude',     'key' => 'address_latitude',  'value' => '21.671914',           'type' => 'text',]);
        Setting::create([ 'display_name' => 'Map Longitude',    'key' => 'address_longitude', 'value' => '39.173875',           'type' => 'text',]);

        Setting::create([ 'display_name' => 'Google Maps API Key',        'key' => 'google_maps_api_key',       'value' => null,  'type' => 'text', 'section' => 'social_accounts', 'ordering' => 1]);
        Setting::create([ 'display_name' => 'Google Recaptcha API Key',   'key' => 'google_recaptcha_api_key',  'value' => null,  'type' => 'text', 'section' => 'social_accounts', 'ordering' => 2]);
        Setting::create([ 'display_name' => 'Google Analytics Client ID', 'key' => 'google_analytics_client_id','value' => null,  'type' => 'text', 'section' => 'social_accounts', 'ordering' => 3]);
        Setting::create([ 'display_name' => 'Facebook ID',                'key' => 'facebook_id',               'value' => 'https://www.facebook.com/', 'type' => 'text', 'section' => 'social_accounts', 'ordering' => 4]);
        Setting::create([ 'display_name' => 'Twitter ID',                 'key' => 'twitter_id',                'value' => 'https://twitter.com/',      'type' => 'text', 'section' => 'social_accounts', 'ordering' => 5]);
        Setting::create([ 'display_name' => 'Instagram ID',               'key' => 'instagram_id',              'value' => 'https://instagram.com/',    'type' => 'text', 'section' => 'social_accounts', 'ordering' => 6]);
        Setting::create([ 'display_name' => 'Patreon ID',                 'key' => 'flickr_id',                 'value' => 'https://www.patreon.com/',  'type' => 'text', 'section' => 'social_accounts', 'ordering' => 7]);
        Setting::create([ 'display_name' => 'Youtube ID',                 'key' => 'youtube_id',                'value' => 'https://www.youtube.com/',  'type' => 'text', 'section' => 'social_accounts', 'ordering' => 8]);

    }
}
