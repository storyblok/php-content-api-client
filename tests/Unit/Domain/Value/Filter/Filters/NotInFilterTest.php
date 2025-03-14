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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Filter\Filters;

use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use Storyblok\Api\Domain\Value\Filter\Filters\NotInFilter;
use Storyblok\Api\Domain\Value\Filter\Operation;
use Storyblok\Api\Tests\Unit\Domain\Value\Filter\FilterTestCase;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class NotInFilterTest extends FilterTestCase
{
    public static function operation(): Operation
    {
        return Operation::NotIn;
    }

    public static function filterClass(): string
    {
        return NotInFilter::class;
    }

    #[Test]
    public function toArray(): void
    {
        $faker = self::faker();
        $filter = new NotInFilter($field = $faker->word(), $value = [$faker->word()]);

        self::assertSame([
            $field => [
                Operation::NotIn->value => implode(',', $value),
            ],
        ], $filter->toArray());
    }

    #[Test]
    public function field(): void
    {
        $faker = self::faker();
        $filter = new NotInFilter($field = $faker->word(), [$faker->word()]);

        self::assertSame($field, $filter->field());
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function fieldInvalid(string $field): void
    {
        self::expectException(\InvalidArgumentException::class);

        new NotInFilter($field, [self::faker()->word()]);
    }

    #[DataProvider('invalidValues')]
    #[Test]
    public function valueInvalid(mixed $value): void
    {
        self::expectException(\InvalidArgumentException::class);

        new NotInFilter(self::faker()->word(), $value);
    }

    /**
     * @return iterable<string, array<mixed>>
     */
    public static function invalidValues(): iterable
    {
        $faker = self::faker();

        yield 'string is empty' => [''];
        yield 'array is empty' => [[]];
        yield 'array not only contains string' => [[$faker->word(), $faker->randomNumber()]];
        yield 'array contains empty string' => [[$faker->word(), '']];
        yield 'array contains whitespace only string' => [[$faker->word(), ' ']];
    }
}
