<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{$channel.title|escape:'html'}</title>
        <link>{$channel.link}</link>
        <description>{$channel.description|escape:'html'}</description>
        <language>{$channel.language}</language>
        <pubDate>{$channel.pubDate}</pubDate>
        <ttl>{$channel.ttl}</ttl>
        <image>
            <url>{$channel.image.url}</url>
            <title>{$channel.image.title}</title>
            <link>{$channel.image.link}</link>
        </image>
{foreach from=$channel.items item="item"}
        <item>
            <title>{$item.title|escape:'html'}</title>
            <link>{$item.link}</link>
            <guid isPermaLink="{if $item.isPermaLink}true{else}false{/if}">{$item.guid}</guid>
            <pubDate>{$item.pubDate}</pubDate>
            <author>{$item.author|escape:'html'}</author>
            <description>{$item.description|escape:'html'}</description>
        </item>
{/foreach}
    </channel>
</rss>