<?php

namespace App\Http\Helpers;

use Illuminate\Support\Str;

class UrlGeneratorHelper
{
    /**
     * @param $title
     * @param $model
     * @return string
     */
    public static function postUrl($title, $model): string
    {
        $slug = $baseSlug = Str::slug($title);

        $count = 0;
        while (self::postUrlExists($slug, $model)) {
            $slug = $baseSlug . '-' . ++$count;
        }

        return $slug;
    }

    /**
     * @param $url
     * @param $model
     * @return bool
     */
    private static function postUrlExists($url, $model): bool
    {
        $exists = $model::where('slug', $url)
            ->first();

        if ($exists) {
            return true;
        }

        return false;
    }
}
