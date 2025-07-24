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

namespace Storyblok\Api\Tests\Unit\Domain\Value\QueryParameter;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\QueryParameter\FirstPublishedAtQueryParameter;
use Storyblok\Api\Domain\Value\QueryParameter\Operator;
use Storyblok\Api\Domain\Value\QueryParameter\PublishedAtQueryParameter;
use Storyblok\Api\Domain\Value\QueryParameter\QueryParameter;
use Storyblok\Api\Domain\Value\QueryParameter\UpdatedAtQueryParameter;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Frank Stelzer <dev@frankstelzer.de>
 */
class DateQueryParameterTest extends TestCase
{
    use FakerTrait;

    #[DataProvider('parametersProvider')]
    #[Test]
    public function constructValid(string $className, Operator $operator, string $expectedName): void
    {
        $value = self::faker()->dateTime();
        $expectedValue = $value->format('Y-m-d H:i');

        $valueObject = new $className($value, $operator);
        self::assertInstanceOf(QueryParameter::class, $valueObject);
        self::assertSame($expectedName, $valueObject->name);
        self::assertSame($expectedValue, $valueObject->value);
    }

    /**
     * @return iterable<string, array{0: string}>
     */
    public static function parametersProvider(): iterable
    {
        yield 'published_at_gt' => [PublishedAtQueryParameter::class, Operator::GreaterThan, 'published_at_gt'];
        yield 'published_at_lt' => [PublishedAtQueryParameter::class, Operator::LessThan, 'published_at_lt'];
        yield 'first_published_at_gt' => [FirstPublishedAtQueryParameter::class, Operator::GreaterThan, 'first_published_at_gt'];
        yield 'first_published_at_lt' => [FirstPublishedAtQueryParameter::class, Operator::LessThan, 'first_published_at_lt'];
        yield 'updated_at_gt' => [UpdatedAtQueryParameter::class, Operator::GreaterThan, 'updated_at_gt'];
        yield 'updated_at_lt' => [UpdatedAtQueryParameter::class, Operator::LessThan, 'updated_at_lt'];
    }
}
