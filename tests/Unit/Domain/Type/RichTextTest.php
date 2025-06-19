<?php

declare(strict_types=1);

/**
 * This file is part of storyblok/php-content-api-client.
 *
 * (c) Storyblok GmbH <info@storyblok.com>
 * in cooperation with SensioLabs Deutschland <info@sensiolabs.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Storyblok\Api\Tests\Unit\Domain\Type;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Type\RichText;
use Storyblok\Api\Tests\Util\FakerTrait;

final class RichTextTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function type(): void
    {
        $values = self::faker()->richTextResponse([
            'type' => $expected = 'doc',
        ]);

        self::assertSame($expected, (new RichText($values))->type);
    }

    #[Test]
    public function typeKeyMustExist(): void
    {
        $values = self::faker()->richTextResponse();
        unset($values['type']);

        self::expectException(\InvalidArgumentException::class);

        new RichText($values);
    }

    #[Test]
    public function typeKeyMustBeTrimmedNonEmptyString(): void
    {
        $values = self::faker()->richTextResponse([
            'type' => ' ',
        ]);

        self::expectException(\InvalidArgumentException::class);

        new RichText($values);
    }

    #[Test]
    public function contentKeyMustExist(): void
    {
        $values = self::faker()->richTextResponse();
        unset($values['content']);

        self::expectException(\InvalidArgumentException::class);

        new RichText($values);
    }

    #[Test]
    public function content(): void
    {
        $values = self::faker()->richTextResponse([
            'content' => $expected = ['foo', 'bar'],
        ]);

        self::assertSame($expected, (new RichText($values))->content);
    }

    #[Test]
    public function contentCanBeEmptyArray(): void
    {
        $values = self::faker()->richTextEmptyResponse();

        self::assertEmpty((new RichText($values))->content);
    }
}
