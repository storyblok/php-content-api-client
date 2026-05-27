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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Dto;

use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Dto\Direction;
use Storyblok\Api\Domain\Value\Dto\SortBy;
use Storyblok\Api\Domain\Value\Dto\SortByDataType;
use Storyblok\Api\Domain\Value\Dto\SortByNulls;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class SortByTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function page(): void
    {
        $value = self::faker()->word();

        self::assertSame($value, (new SortBy($value, Direction::Asc))->field);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function pageInvalid(string $value): void
    {
        self::expectException(\InvalidArgumentException::class);

        new SortBy($value, Direction::Asc);
    }

    #[Test]
    public function toStringMethod(): void
    {
        $value = self::faker()->word();

        self::assertSame(\sprintf('%s:%s', $value, Direction::Asc->value), (new SortBy($value, Direction::Asc))->toString());
    }

    #[Test]
    public function toStringMethodWithDataType(): void
    {
        self::assertSame(
            'content.price:asc:float',
            (new SortBy('content.price', Direction::Asc, SortByDataType::Float))->toString(),
        );
    }

    #[Test]
    public function toStringMethodWithNullHandling(): void
    {
        self::assertSame(
            'path:desc:nulls_first',
            (new SortBy('path', Direction::Desc, null, SortByNulls::First))->toString(),
        );
    }

    #[Test]
    public function toStringMethodWithDataTypeAndNullHandling(): void
    {
        self::assertSame(
            'content.event_number:desc:int:nulls_last',
            (new SortBy('content.event_number', Direction::Desc, SortByDataType::Int, SortByNulls::Last))->toString(),
        );
    }
}
