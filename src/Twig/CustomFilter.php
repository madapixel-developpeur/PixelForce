<?php


namespace App\Twig;


use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\CacheItem;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CustomFilter extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('base64_encode', [$this, 'base64_encode']),
            new TwigFilter('base64_decode', [$this, 'base64_decode']),
            new TwigFilter('cacheNumber', [$this, 'cacheNumber']),
            new TwigFilter('truncate', [$this, 'truncate']),
            new TwigFilter('replace_string', [$this, 'replaceString']),
        ];
    }

    public function base64_encode($string)
    {
        return base64_encode($string);
    }

    public function base64_decode($string)
    {
        return base64_decode($string);
    }

    public function cacheNumber($date)
    {
        $cache = new FilesystemAdapter();
        $cacheNumber = $cache->get($date, function (ItemInterface $item) {
            // détruire après 24h
            $item->expiresAfter(86400);

            return 0;
        });
        /** @var CacheItem $cacheNumberItem */
        $cacheNumberItem = $cache->getItem($date);

        $cacheNumberItem->set($cacheNumber + 1);
        $cache->save($cacheNumberItem);

        return $date . '-' . $cacheNumberItem->get();

    }

    public function truncate(string $text, int $limit): string
    {
        return mb_strlen($text) > $limit ? mb_substr($text, 0, $limit) . '...' : $text;
    }

    public function replaceString(string $text, string $search, string $replace): string
    {
        return str_replace($search, $replace, $text);
    }
}
