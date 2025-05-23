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
use Storyblok\Api\Domain\Value\DatasourceDimension;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class DatasourceDimensionTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function id(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse([
            'id' => $id = $faker->numberBetween(1),
        ]);

        self::assertSame($id, (new DatasourceDimension($response))->id->value);
    }

    #[Test]
    public function idKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse();
        unset($response['id']);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceDimension($response);
    }

    #[Test]
    public function nameValue(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse([
            'name' => $name = $faker->word(),
        ]);

        self::assertSame($name, (new DatasourceDimension($response))->name);
    }

    #[Test]
    public function nameKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse();
        unset($response['name']);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceDimension($response);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function nameInvalid(string $value): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse(['name' => $value]);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceDimension($response);
    }

    #[Test]
    public function entryValue(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse([
            'entry_value' => $entryValue = $faker->word(),
        ]);

        self::assertSame($entryValue, (new DatasourceDimension($response))->entryValue);
    }

    #[Test]
    public function entryValueKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse();
        unset($response['entry_value']);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceDimension($response);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function entryValueInvalid(string $value): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse(['entry_value' => $value]);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceDimension($response);
    }

    #[Test]
    public function datasourceId(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse([
            'datasource_id' => $id = $faker->numberBetween(1),
        ]);

        self::assertSame($id, (new DatasourceDimension($response))->datasourceId->value);
    }

    #[Test]
    public function datasourceIdKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse();
        unset($response['datasource_id']);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceDimension($response);
    }

    #[Test]
    public function createdAt(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse([
            'created_at' => $createdAt = $faker->dateTime()->format('Y-m-d H:i'),
        ]);

        self::assertSame($createdAt, (new DatasourceDimension($response))->createdAt->format('Y-m-d H:i'));
    }

    #[Test]
    public function createdAtKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse();
        unset($response['created_at']);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceDimension($response);
    }

    #[Test]
    public function updatedAt(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse([
            'updated_at' => $updatedAt = $faker->dateTime()->format('Y-m-d H:i'),
        ]);

        self::assertSame($updatedAt, (new DatasourceDimension($response))->updatedAt->format('Y-m-d H:i'));
    }

    #[Test]
    public function updatedAtKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceDimensionResponse();
        unset($response['updated_at']);

        self::expectException(\InvalidArgumentException::class);

        new DatasourceDimension($response);
    }
}
