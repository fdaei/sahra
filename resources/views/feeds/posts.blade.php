<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ $siteName }}</title>
        <link>{{ $home }}</link>
        <description>{{ $description }}</description>
        <language>{{ $language }}</language>
        <atom:link href="{{ $feed }}" rel="self" type="application/rss+xml" />
        @foreach ($items as $item)
            <item>
                <title>{{ $item['title'] }}</title>
                <link>{{ $item['link'] }}</link>
                <guid isPermaLink="false">{{ $item['guid'] }}</guid>
                <description>{{ $item['description'] }}</description>
                @if ($item['published'])
                    <pubDate>{{ $item['published'] }}</pubDate>
                @endif
            </item>
        @endforeach
    </channel>
</rss>
