<?php

declare(strict_types=1);

namespace App\Util;

final class SlugUtil
{
    public static function generate(string $str): string
    {
        $result = \strtolower($str);
        $result = \preg_replace('/[\.\-]/', '', $result);
        $result = \preg_replace('/[\s]+/', '-', $result);

        return $result;
    }
}
