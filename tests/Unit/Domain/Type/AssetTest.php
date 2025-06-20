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

use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Type\Asset;
use Storyblok\Api\Domain\Type\Orientation;
use Storyblok\Api\Tests\Util\FakerTrait;

final class AssetTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function alt(): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'alt' => $expected = $faker->word(),
        ]);

        self::assertSame($expected, (new Asset($response))->alt);
    }

    #[Test]
    public function altKeyIsOptional(): void
    {
        $response = self::faker()->storyAssetResponse();
        unset($response['alt']);

        self::assertNull((new Asset($response))->alt);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[Test]
    public function altInvalid(string $value): void
    {
        $response = self::faker()->storyAssetResponse([
            'alt' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new Asset($response);
    }

    #[Test]
    public function title(): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'title' => $expected = $faker->word(),
        ]);

        self::assertSame($expected, (new Asset($response))->title);
    }

    #[Test]
    public function titleKeyIsOptional(): void
    {
        $response = self::faker()->storyAssetResponse();
        unset($response['title']);

        self::assertNull((new Asset($response))->title);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[Test]
    public function titleInvalid(string $value): void
    {
        $response = self::faker()->storyAssetResponse([
            'title' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new Asset($response);
    }

    #[Test]
    public function focus(): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'focus' => $expected = $faker->word(),
        ]);

        self::assertSame($expected, (new Asset($response))->focus);
    }

    #[Test]
    public function focusKeyIsOptional(): void
    {
        $response = self::faker()->storyAssetResponse();
        unset($response['focus']);

        self::assertNull((new Asset($response))->focus);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[Test]
    public function focusInvalid(string $value): void
    {
        $response = self::faker()->storyAssetResponse([
            'focus' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new Asset($response);
    }

    #[Test]
    public function source(): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'source' => $expected = $faker->word(),
        ]);

        self::assertSame($expected, (new Asset($response))->source);
    }

    #[Test]
    public function sourceKeyIsOptional(): void
    {
        $response = self::faker()->storyAssetResponse();
        unset($response['source']);

        self::assertNull((new Asset($response))->source);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[Test]
    public function sourceInvalid(string $value): void
    {
        $response = self::faker()->storyAssetResponse([
            'source' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new Asset($response);
    }

    #[Test]
    public function copyright(): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'copyright' => $expected = $faker->word(),
        ]);

        self::assertSame($expected, (new Asset($response))->copyright);
    }

    #[Test]
    public function copyrightKeyIsOptional(): void
    {
        $response = self::faker()->storyAssetResponse();
        unset($response['copyright']);

        self::assertNull((new Asset($response))->copyright);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[Test]
    public function copyrightInvalid(string $value): void
    {
        $response = self::faker()->storyAssetResponse([
            'copyright' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new Asset($response);
    }

    #[Test]
    public function filename(): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'filename' => $expected = $faker->assetFilename(),
        ]);

        self::assertSame($expected, (new Asset($response))->url);
    }

    #[Test]
    public function filenameKeyMustExist(): void
    {
        $response = self::faker()->storyAssetResponse();
        unset($response['filename']);

        self::expectException(\InvalidArgumentException::class);

        new Asset($response);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function filenameInvalid(string $value): void
    {
        $response = self::faker()->storyAssetResponse([
            'filename' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new Asset($response);
    }

    #[Test]
    public function height(): void
    {
        $faker = self::faker();

        $response = $faker->storyAssetResponse([
            'filename' => $faker->assetFilename(height: $expected = $faker->randomNumber()),
        ]);

        self::assertSame($expected, (new Asset($response))->height);
    }

    #[Test]
    public function heightCanBeZero(): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'filename' => $faker->word(),
        ]);

        self::assertSame(0, (new Asset($response))->height);
    }

    #[Test]
    public function width(): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'filename' => $faker->assetFilename(width: $expected = $faker->randomNumber()),
        ]);

        self::assertSame($expected, (new Asset($response))->width);
    }

    #[Test]
    public function widthCanBeZero(): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'filename' => $faker->word(),
        ]);

        self::assertSame(0, (new Asset($response))->width);
    }

    #[DataProvider('orientationProvider')]
    #[Test]
    public function orientation(Orientation $expected, int $width, int $height): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'filename' => $faker->assetFilename($width, $height),
        ]);

        self::assertTrue($expected->equals((new Asset($response))->orientation));
    }

    #[Test]
    public function orientationWithNoImage(): void
    {
        $faker = self::faker();
        $response = $faker->storyAssetResponse([
            'filename' => $faker->url(),
        ]);

        self::assertTrue(Orientation::Unknown->equals((new Asset($response))->orientation));
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
