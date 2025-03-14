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
use Ergebnis\DataProvider\NullProvider;
use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Space;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class SpaceTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function id(): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse([
            'id' => $id = $faker->numberBetween(1),
        ]);

        self::assertSame($id, (new Space($response))->id->value);
    }

    #[Test]
    public function idKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse();
        unset($response['id']);

        self::expectException(\InvalidArgumentException::class);

        new Space($response);
    }

    #[Test]
    public function nameValue(): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse([
            'name' => $name = $faker->word(),
        ]);

        self::assertSame($name, (new Space($response))->name);
    }

    #[Test]
    public function nameKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse();
        unset($response['name']);

        self::expectException(\InvalidArgumentException::class);

        new Space($response);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function nameInvalid(string $value): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse(['name' => $value]);

        self::expectException(\InvalidArgumentException::class);

        new Space($response);
    }

    #[Test]
    public function version(): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse([
            'version' => $version = $faker->numberBetween(1),
        ]);

        self::assertSame($version, (new Space($response))->version);
    }

    #[Test]
    public function versionKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse();
        unset($response['version']);

        self::expectException(\InvalidArgumentException::class);

        new Space($response);
    }

    #[DataProviderExternal(IntProvider::class, 'lessThanZero')]
    #[DataProviderExternal(IntProvider::class, 'zero')]
    #[DataProviderExternal(StringProvider::class, 'arbitrary')]
    #[Test]
    public function versionInvalid(int|string $value): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse(['version' => $value]);

        self::expectException(\InvalidArgumentException::class);

        new Space($response);
    }

    #[Test]
    public function languageCodes(): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse([
            'language_codes' => $languageCodes = ['de', 'en', 'fr'],
        ]);

        self::assertSame($languageCodes, (new Space($response))->languageCodes);
    }

    #[Test]
    public function languageCodesKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse();
        unset($response['language_codes']);

        self::expectException(\InvalidArgumentException::class);

        new Space($response);
    }

    #[DataProviderExternal(IntProvider::class, 'arbitrary')]
    #[DataProviderExternal(NullProvider::class, 'null')]
    #[DataProviderExternal(StringProvider::class, 'arbitrary')]
    #[Test]
    public function languageCodesMustBeArray(mixed $value): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse(['language_codes' => $value]);

        self::expectException(\InvalidArgumentException::class);

        new Space($response);
    }

    #[Test]
    public function languageCodesMustAllArray(): void
    {
        $faker = self::faker();
        $response = $faker->spaceResponse(['language_codes' => ['de', $faker->randomNumber()]]);

        self::expectException(\InvalidArgumentException::class);

        new Space($response);
    }
}
