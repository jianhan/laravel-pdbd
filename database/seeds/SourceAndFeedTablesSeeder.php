<?php

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
            ],
            [
                'name' => 'SitePoint',
                'url' => 'https://www.sitepoint.com',
            ],
            [
                'name' => 'Reddit Programming',
                'url' => 'https://www.reddit.com/r/programming',
            ],
            [
                'name' => 'Code Pen',
                'url' => 'https://blog.codepen.io',
            ],
            [
                'name' => 'The Go Programming Language Blog',
                'url' => 'https://blog.golang.org',
            ],
            [
                'name' => 'Coding Dojo Blog',
                'url' => 'https://www.codingdojo.com/blog',
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
            // [
            //     'name' => 'DZone',
            //     'url' => 'https://dzone.com',
            // ],
        ];

        // info q
        // coderwall
        // d zone
    }
}
