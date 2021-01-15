<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Webmention
{
    public $author;
    public $url;
    public $verb;
    public $date;
    public $text;

    public function __construct($data)
    {
        $verbs = [
            'in-reply-to' => 'replied',
            'like-of' => 'liked',
            'repost-of' => 'retweeted',
            'bookmark-of' => 'bookmarked',
            'mention-of' => 'mentioned',
            'rsvp' => 'RSVPed',
            'follow-of' => 'followed',
        ];
        $this->author = (object) $data['author'];
        $this->url = $data['url'];
        $this->verb = $verbs[$data['wm-property']] ?? null;
        $this->date = new Carbon($data['published'] ?? $data['wm-received']);
        $this->text = array_key_exists('content', $data) ? $data['content']['text'] : null;
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }
}

return [
    'baseUrl' => 'http://imacrayon.test',
    'production' => false,
    'siteName' => "I'm a crayon",
    'siteDescription' => 'Work by Christian Taylor. An artist & full stack developer based in Wichita, KS.',
    'siteAuthor' => 'Christian Taylor',
    'collections' => [
        'posts' => [
            'author' => 'Christian Taylor', // Default author, if not provided in a post
            'sort' => '-date',
            'path' => 'words/{filename}',
        ],
        'pictures' => [
            'sort' => '-date',
            'path' => 'pictures/{filename}',
        ],
        'categories' => [
            'path' => '/words/categories/{filename}',
            'posts' => function ($page, $allPosts) {
                return $allPosts->filter(function ($post) use ($page) {
                    return $post->categories ? in_array($page->getFilename(), $post->categories, true) : false;
                });
            },
        ],
    ],

    // helpers
    'getDate' => function ($page) {
        return Datetime::createFromFormat('U', $page->date);
    },
    'getExcerpt' => function ($page, $length = 255) {
        if ($page->excerpt) {
            return $page->excerpt;
        }

        $content = preg_split('/<!-- more -->/m', $page->getContent(), 2);
        $cleaned = trim(
            strip_tags(
                preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content[0]),
                '<code>'
            )
        );

        if (count($content) > 1) {
            return $cleaned;
        }

        $truncated = substr($cleaned, 0, $length);

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated).'...'
            : $cleaned;
    },
    'getWebmentions' => function ($page) {
        $path = $page->getPath() ?: 'index';
        $path = 'webmentions'.$page->getPath().'.json';
        if (file_exists($path)) {
            return (new Collection(json_decode(file_get_contents($path), true)))
                ->map(fn ($entry) => new Webmention($entry));
        }

        return new Collection();
    },
    'isActive' => function ($page, $path) {
        return Str::is($path, $page->getPath());
    },
];
