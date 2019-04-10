<?php

use App\Models\RssFeed;
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
        ];

        foreach ($data as $row) {
            $rssFeed = new RssFeed();
            $rssFeed->name = $row['name'];
            $rssFeed->url = $row['url'];
            $rssFeed->site_url = $row['site_url'];
            $rssFeed->logo = Str::slug($row['name']) . '.png';
        }
    }
}
