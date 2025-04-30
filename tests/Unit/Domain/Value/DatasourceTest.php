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
use Storyblok\Api\Domain\Value\Datasource;
use Storyblok\Api\Domain\Value\DatasourceDimension;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class DatasourceTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function id(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceResponse([
            'id' => $id = $faker->numberBetween(1),
        ]);

        self::assertSame($id, (new Datasource($response))->id->value);
    }

    #[Test]
    public function idKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceResponse();
        unset($response['id']);

        self::expectException(\InvalidArgumentException::class);

        new Datasource($response);
    }

    #[Test]
    public function nameValue(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceResponse([
            'name' => $name = $faker->word(),
        ]);

        self::assertSame($name, (new Datasource($response))->name);
    }

    #[Test]
    public function nameKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceResponse();
        unset($response['name']);

        self::expectException(\InvalidArgumentException::class);

        new Datasource($response);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function nameInvalid(string $value): void
    {
        $faker = self::faker();
        $response = $faker->datasourceResponse(['name' => $value]);

        self::expectException(\InvalidArgumentException::class);

        new Datasource($response);
    }

    #[Test]
    public function slug(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceResponse([
            'slug' => $slug = $faker->word(),
        ]);

        self::assertSame($slug, (new Datasource($response))->slug);
    }

    #[Test]
    public function slugKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceResponse();
        unset($response['slug']);

        self::expectException(\InvalidArgumentException::class);

        new Datasource($response);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function slugInvalid(string $value): void
    {
        $faker = self::faker();
        $response = $faker->datasourceResponse(['slug' => $value]);

        self::expectException(\InvalidArgumentException::class);

        new Datasource($response);
    }

    #[Test]
    public function dimensions(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceResponse();

        self::assertContainsOnlyInstancesOf(
            DatasourceDimension::class,
            (new Datasource($response))->dimensions,
        );
    }

    #[Test]
    public function dimensionsKeyMustExist(): void
    {
        $faker = self::faker();
        $response = $faker->datasourceResponse();
        unset($response['dimensions']);

        self::expectException(\InvalidArgumentException::class);

        new Datasource($response);
    }
}
