<?php

use App\Models\RssFeed;
use Illuminate\Database\Seeder;

class FeedSourcesTableSeeder extends Seeder
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
                'name' => 'InfoQ',
                'url' => 'https://feed.infoq.com/news',
                'site_url' => 'https://www.infoq.com',
            ],
            [
                'name' => 'DZone',
                'url' => 'http://feeds.dzone.com/home',
                'site_url' => 'https://dzone.com',
            ],
        ];

        // info q
        // coderwall
        // d zone

        foreach ($data as $row) {
            $feedSource = new RssFeed();
            $feedSource->name = $row['name'];
            $feedSource->url = $row['url'];
            $feedSource->site_url = $row['site_url'];
            $feedSource->logo = Str::slug($row['name']) . '.png';
            $feedSource->save();
        }
    }
}
