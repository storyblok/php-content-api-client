<?php

declare(strict_types=1);

/**
 * This file is part of Storyblok-Api.
 *
 * (c) SensioLabs Deutschland <info@sensiolabs.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Storyblok\Api\Tests\Unit\Domain\Value;

use Ergebnis\DataProvider\IntProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Asset;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class AssetTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function filename(): void
    {
        $values = self::faker()->assetResponse()['asset'];

        self::assertSame($values['filename'], (new Asset($values))->filename);
    }

    #[Test]
    public function filenameKeyMustExist(): void
    {
        $values = self::faker()->assetResponse()['asset'];
        unset($values['filename']);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[Test]
    public function createdAt(): void
    {
        $values = self::faker()->assetResponse()['asset'];

        self::assertSame($values['created_at'], (new Asset($values))->createdAt->format(\DATE_ATOM));
    }

    #[Test]
    public function createdAtKeyMustExist(): void
    {
        $values = self::faker()->assetResponse()['asset'];
        unset($values['created_at']);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[Test]
    public function updatedAt(): void
    {
        $values = self::faker()->assetResponse()['asset'];

        self::assertSame($values['updated_at'], (new Asset($values))->updatedAt->format(\DATE_ATOM));
    }

    #[Test]
    public function updatedAtKeyMustExist(): void
    {
        $values = self::faker()->assetResponse()['asset'];
        unset($values['updated_at']);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[Test]
    public function expiresAt(): void
    {
        $faker = self::faker();

        $values = $faker->assetResponse([
            'asset' => [
                'expire_at' => $faker->dateTime()->format(\DATE_ATOM),
            ],
        ])['asset'];

        self::assertSame($values['expire_at'], (new Asset($values))->expiresAt->format(\DATE_ATOM));
    }

    #[Test]
    public function expiresAtCanBeNull(): void
    {
        $faker = self::faker();

        $values = $faker->assetResponse([
            'asset' => [
                'expire_at' => null,
            ],
        ])['asset'];

        self::assertNull((new Asset($values))->expiresAt);
    }

    #[Test]
    public function expiresAtKeyMustExist(): void
    {
        $values = self::faker()->assetResponse()['asset'];
        unset($values['expire_at']);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[Test]
    public function contentLength(): void
    {
        $values = self::faker()->assetResponse()['asset'];

        self::assertSame($values['content_length'], (new Asset($values))->contentLength);
    }

    #[Test]
    public function contentLengthKeyMustExist(): void
    {
        $values = self::faker()->assetResponse()['asset'];
        unset($values['content_length']);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[DataProviderExternal(IntProvider::class, 'lessThanZero')]
    #[Test]
    public function contentLengthInvalid(int $value): void
    {
        $values = self::faker()->assetResponse([
            'asset' => [
                'content_length' => $value,
            ],
        ])['asset'];

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[Test]
    public function signedUrl(): void
    {
        $values = self::faker()->assetResponse()['asset'];

        self::assertSame($values['signed_url'], (new Asset($values))->signedUrl);
    }

    #[Test]
    public function signedUrlKeyMustExist(): void
    {
        $values = self::faker()->assetResponse()['asset'];
        unset($values['signed_url']);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }

    #[Test]
    public function contentType(): void
    {
        $values = self::faker()->assetResponse()['asset'];

        self::assertSame($values['content_type'], (new Asset($values))->contentType);
    }

    #[Test]
    public function contentTypeKeyMustExist(): void
    {
        $values = self::faker()->assetResponse()['asset'];
        unset($values['content_type']);

        self::expectException(\InvalidArgumentException::class);

        new Asset($values);
    }
}
