<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Uploader
{
    /**
     * @param $path
     * @param $file
     * @return string
     */
    public static function upload($path, $file): string
    {
        $name = Str::random(32) . '.' . $file->getClientOriginalExtension();

        $routes = explode('/', $path);

        $link = '';
        foreach ($routes as $item) {
            $link .= $item . '/';
            if (!file_exists(public_path($link))) {
                mkdir(public_path($link));
            }
        }

        $file->move($path, $name);

        return self::getHostUrl() . '/' . $path . '/' . $name;
    }

    /**
     * @return string
     */
    public static function getHostUrl(): string
    {
        $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';

        return $protocol . $_SERVER['HTTP_HOST'];
    }

    /**
     * @param string $path
     */
    public static function deleteAttachment(string $path)
    {
        $path = parse_url($path)['path'];
        $path = mb_substr($path, 1);
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
