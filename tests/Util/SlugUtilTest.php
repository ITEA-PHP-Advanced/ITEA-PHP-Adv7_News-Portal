<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Util\SlugUtil;
use PHPUnit\Framework\TestCase;

final class SlugUtilTest extends TestCase
{
    /**
     * @dataProvider provideStringsAndSlugs
     */
    public function testGenerate(string $str, string $slug): void
    {
        $actual = SlugUtil::generate($str);

        static::assertEquals($slug, $actual);
    }

    public function provideStringsAndSlugs(): iterable
    {
        yield '#1 lower case only' => [
            'this is test',
            'this-is-test',
        ];

        yield '#2 lower and upper case' => [
            'This is Test',
            'this-is-test',
        ];

        yield '#3 non-word chars' => [
            'This is - test.',
            'this-is-test',
        ];
    }
}
