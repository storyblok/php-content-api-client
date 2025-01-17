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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Resolver;

use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Resolver\Relation;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class RelationTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function value(): void
    {
        $value = self::faker()->relation();

        self::assertSame($value, (new Relation($value))->value);
    }

    /**
     * @test
     *
     * @dataProvider \Ergebnis\DataProvider\StringProvider::arbitrary()
     * @dataProvider \Ergebnis\DataProvider\StringProvider::blank()
     * @dataProvider \Ergebnis\DataProvider\StringProvider::empty()
     */
    public function valueInvalid(string $value): void
    {
        self::expectException(\InvalidArgumentException::class);

        new Relation($value);
    }
}
