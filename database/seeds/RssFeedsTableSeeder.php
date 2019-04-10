<?php

use Illuminate\Database\Seeder;

class RssFeedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'The Crazy Programmer',
                'url' => 'https://www.thecrazyprogrammer.com/feed',
                'site_url' => 'https://www.thecrazyprogrammer.com',
            ],
            [
                'name' => 'SitePoint',
                'url' => 'https://www.sitepoint.com/feed',
                'site_url' => 'https://www.sitepoint.com',
            ],
            [
                'name' => 'Reddit Programming',
                'url' => 'https://www.reddit.com/r/programming/.rss',
                'site_url' => 'https://www.reddit.com/r/programming',
            ],
            [
                'name' => 'Code Pen',
                'url' => 'https://blog.codepen.io/feed',
                'site_url' => 'https://blog.codepen.io',
            ],
            [
                'name' => 'The Go Programming Language Blog',
                'url' => 'https://blog.golang.org/feed.atom?format=xml',
                'site_url' => 'https://blog.golang.org',
            ],
            [
                'name' => 'Coding Dojo Blog',
                'url' => 'https://www.codingdojo.com/blog/feed',
                'site_url' => 'https://www.codingdojo.com/blog',
            ],
            [
                'name' => 'InfoQ - InfoQ',
                'url' => 'https://feed.infoq.com/InfoQ',
                'site_url' => 'https://www.infoq.com',
            ],
        ];

        \DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
