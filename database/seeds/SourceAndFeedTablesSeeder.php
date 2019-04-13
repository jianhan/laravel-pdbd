<?php

use App\Models\Feed;
use App\Models\Source;
use Illuminate\Database\Seeder;

class SourceAndFeedTablesSeeder extends Seeder
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
                'url' => 'https://www.thecrazyprogrammer.com',
                'feeds' => [
                    ['url' => 'feed'],
                ],
            ],
            [
                'name' => 'SitePoint',
                'url' => 'https://www.sitepoint.com',
                'feeds' => [
                    ['url' => 'feed'],
                ],
            ],
            [
                'name' => 'Reddit Programming',
                'url' => 'https://www.reddit.com/r/programming',
                'feeds' => [
                    ['url' => '.rss'],
                ],
            ],
            [
                'name' => 'Code Pen',
                'url' => 'https://blog.codepen.io',
                'feeds' => [
                    ['url' => '.rss'],
                ],
            ],
            [
                'name' => 'The Go Programming Language Blog',
                'url' => 'https://blog.golang.org',
                'feeds' => [
                    ['url' => 'feed.atom?format=xml'],
                ],
            ],
            [
                'name' => 'Coding Dojo Blog',
                'url' => 'https://www.codingdojo.com/blog',
                'feeds' => [
                    ['url' => 'feed'],
                ],
            ],
            [
                'name' => 'InfoQ',
                'url' => 'https://www.infoq.com',
                'feed_root_url' => 'https://feed.infoq.com',
                'feeds' => [
                    ['url' => 'news'],
                    ['url' => 'development'],
                    ['url' => 'architecture-design'],
                    ['url' => 'ai-ml-data-eng'],
                    ['url' => 'culture-methods'],
                    ['url' => 'Devops'],
                    ['url' => 'microservices'],
                    ['url' => 'Containers'],
                    ['url' => 'Deep+Learning'],
                ],
            ],
            [
                'name' => 'DZone',
                'url' => 'https://dzone.com',
                'feed_root_url' => 'http://feeds.dzone.com',
                'feeds' => [
                    ['url' => 'ai'],
                    ['url' => 'agile'],
                    ['url' => 'big-data'],
                    ['url' => 'cloud'],
                    ['url' => 'database'],
                    ['url' => 'devops'],
                    ['url' => 'integration'],
                    ['url' => 'iot'],
                    ['url' => 'microservices'],
                    ['url' => 'mobile'],
                    ['url' => 'performance'],
                    ['url' => 'security'],
                    ['url' => 'webdev'],
                ],
            ],
        ];

        foreach ($data as $sourceRecord) {
            $source = new Source();
            $source->url = $sourceRecord['url'];
            $source->name = $sourceRecord['name'];
            $source->logo = Str::slug($sourceRecord['name'], '-');
            $source->save();
            if (isset($sourceRecord['feeds'])) {
                $feeds = [];
                foreach ($sourceRecord['feeds'] as $feedRecord) {
                    $feed = new Feed();
                    $feed->url = trim($source->feed_root_url, '/') . '/' . $feedRecord['url'];
                    array_push($feeds, $feed);
                }
                $source->feeds()->saveMany($feeds);
            }
        }
    }
}
