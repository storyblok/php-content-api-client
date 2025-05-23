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

use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\DatasourceEntry;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class DatasourceEntryTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function id(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse([
            'id' => $id = $faker->numberBetween(1),
        ]);

        self::assertSame($id, (new DatasourceEntry($response))->id->value);
    }

    #[Test]
    public function idKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse();
        unset($response['id']);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceEntry($response);
    }

    #[Test]
    public function nameValue(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse([
            'name' => $name = $faker->word(),
        ]);

        self::assertSame($name, (new DatasourceEntry($response))->name);
    }

    #[Test]
    public function nameKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse();
        unset($response['name']);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceEntry($response);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function nameInvalid(string $value): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse(['name' => $value]);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceEntry($response);
    }

    #[Test]
    public function value(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse([
            'value' => $value = $faker->word(),
        ]);

        self::assertSame($value, (new DatasourceEntry($response))->value);
    }

    #[Test]
    public function valueKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse();
        unset($response['value']);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceEntry($response);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function valueInvalid(string $value): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse(['value' => $value]);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceEntry($response);
    }

    #[Test]
    public function dimensionValue(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse([
            'dimension_value' => $dimensionValue = $faker->word(),
        ]);

        self::assertSame($dimensionValue, (new DatasourceEntry($response))->dimensionValue);
    }

    #[Test]
    public function dimensionValueCanBeNull(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse([
            'dimension_value' => null,
        ]);

        self::assertNull((new DatasourceEntry($response))->dimensionValue);
    }

    #[Test]
    public function dimensionValueKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse();
        unset($response['dimension_value']);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceEntry($response);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function dimensionValueInvalid(string $value): void
    {
        $faker = self::faker();
        $response = $faker->datasourceEntryResponse(['dimension_value' => $value]);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceEntry($response);
    }
}
