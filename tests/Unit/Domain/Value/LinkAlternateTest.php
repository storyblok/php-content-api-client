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

namespace Storyblok\Api\Tests\Unit\Domain\Value;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\LinkAlternate;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class LinkAlternateTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function lang(): void
    {
        $values = self::faker()->linkAlternateResponse();

        self::assertSame($values['lang'], (new LinkAlternate($values))->lang);
    }

    #[Test]
    public function langKeyMustExist(): void
    {
        $values = self::faker()->linkAlternateResponse();
        unset($values['lang']);

        self::expectException(\InvalidArgumentException::class);

        new LinkAlternate($values);
    }

    #[Test]
    public function nameValue(): void
    {
        $values = self::faker()->linkAlternateResponse();

        self::assertSame($values['name'], (new LinkAlternate($values))->name);
    }

    #[Test]
    public function nameKeyMustExist(): void
    {
        $values = self::faker()->linkAlternateResponse();
        unset($values['name']);

        self::expectException(\InvalidArgumentException::class);

        new LinkAlternate($values);
    }

    #[Test]
    public function path(): void
    {
        $values = self::faker()->linkAlternateResponse();

        self::assertSame($values['path'], (new LinkAlternate($values))->path);
    }

    #[Test]
    public function pathKeyMustExist(): void
    {
        $values = self::faker()->linkAlternateResponse();
        unset($values['path']);

        self::expectException(\InvalidArgumentException::class);

        new LinkAlternate($values);
    }

    #[Test]
    public function published(): void
    {
        $values = self::faker()->linkAlternateResponse();

        self::assertSame($values['published'], (new LinkAlternate($values))->published);
    }

    #[Test]
    public function publishedKeyMustExist(): void
    {
        $values = self::faker()->linkAlternateResponse();
        unset($values['published']);

        self::expectException(\InvalidArgumentException::class);

        new LinkAlternate($values);
    }

    #[Test]
    public function slug(): void
    {
        $values = self::faker()->linkAlternateResponse();

        self::assertSame($values['translated_slug'], (new LinkAlternate($values))->slug);
    }

    #[Test]
    public function slugKeyHasFallback(): void
    {
        $values = self::faker()->linkAlternateResponse([
            'path' => $path = self::faker()->slug(),
        ]);

        unset($values['translated_slug']);

        self::assertSame($path, (new LinkAlternate($values))->slug);
    }

    #[Test]
    public function isPublishedReturnsTrue(): void
    {
        $values = self::faker()->linkAlternateResponse(['published' => true]);

        self::assertTrue((new LinkAlternate($values))->isPublished());
    }

    #[Test]
    public function isPublishedReturnsFalse(): void
    {
        $values = self::faker()->linkAlternateResponse(['published' => false]);

        self::assertFalse((new LinkAlternate($values))->isPublished());
    }
}
