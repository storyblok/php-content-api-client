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

use App\Bridge\Storyblok\Value\Type\Asset;
use App\Bridge\Storyblok\Value\Type\Orientation;
use App\Factory\Storyblok\Type\AssetResponseFactory;
use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Tests\Util\FakerTrait;

final class AssetTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function alt(): void
    {
        $asset = self::faker()->storyAssetResponse();

        $values = AssetResponseFactory::createOne([
            'alt' => $expected = self::faker()->word(),
        ]);

        self::assertSame($expected, (new Asset($values))->alt);
    }

    #[Test]
    public function altKeyMustExist(): void
    {
        $values = AssetResponseFactory::createOne();
        unset($values['alt']);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function altInvalid(string $value): void
    {
        $values = AssetResponseFactory::createOne([
            'alt' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[Test]
    public function filename(): void
    {
        $values = AssetResponseFactory::createOne([
            'filename' => $expected = self::faker()->storyblokAssetFilename(),
        ]);

        self::assertSame($expected, (new Asset($values))->url);
    }

    #[Test]
    public function filenameKeyMustExist(): void
    {
        $values = AssetResponseFactory::createOne();
        unset($values['filename']);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function filenameInvalid(string $value): void
    {
        $values = AssetResponseFactory::createOne([
            'filename' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[Test]
    public function height(): void
    {
        $faker = self::faker();

        $values = AssetResponseFactory::createOne([
            'filename' => $faker->storyblokAssetFilename(height: $expected = $faker->randomNumber()),
        ]);

        self::assertSame($expected, (new Asset($values))->height);
    }

    #[Test]
    public function heightCanBeZero(): void
    {
        $values = AssetResponseFactory::createOne([
            'filename' => self::faker()->word(),
        ]);

        self::assertSame(0, (new Asset($values))->height);
    }

    #[Test]
    public function width(): void
    {
        $faker = self::faker();

        $values = AssetResponseFactory::createOne([
            'filename' => $faker->storyblokAssetFilename(width: $expected = $faker->randomNumber()),
        ]);

        self::assertSame($expected, (new Asset($values))->width);
    }

    #[Test]
    public function widthCanBeZero(): void
    {
        $values = AssetResponseFactory::createOne([
            'filename' => self::faker()->word(),
        ]);

        self::assertSame(0, (new Asset($values))->width);
    }

    #[DataProvider('orientationProvider')]
    #[Test]
    public function orientation(Orientation $expected, int $width, int $height): void
    {
        $faker = self::faker();

        $values = AssetResponseFactory::createOne([
            'filename' => $faker->storyblokAssetFilename(
                width: $width,
                height: $height,
            ),
        ]);

        self::assertTrue($expected->equals((new Asset($values))->orientation));
    }

    #[Test]
    public function orientationWithNoImage(): void
    {
        $faker = self::faker();

        $values = AssetResponseFactory::createOne([
            'filename' => $faker->url(),
        ]);

        self::assertTrue(Orientation::Unknown->equals((new Asset($values))->orientation));
    }

    /**
     * @return iterable<string, array{0: Orientation, 1: int, 2: int}>
     */
    public static function orientationProvider(): iterable
    {
        yield 'unknown' => [Orientation::Unknown, 0, 0];
        yield 'square' => [Orientation::Square, 100, 100];
        yield 'square with 8% more width' => [Orientation::Square, 108, 100];
        yield 'square with 8% more height' => [Orientation::Square, 100, 108];
        yield 'landscape' => [Orientation::Landscape, 1920, 1080];
        yield 'portrait' => [Orientation::Portrait, 1080, 1920];
    }
}
