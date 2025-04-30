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

namespace Storyblok\Api\Tests\Unit\Response;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Response\SpaceResponse;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class SpaceResponseTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function space(): void
    {
        $response = [
            'space' => $values = self::faker()->spaceResponse(),
        ];

        $space = (new SpaceResponse($response))->space;
        self::assertSame($values['id'], $space->id->value);
        self::assertSame($values['name'], $space->name);
        self::assertSame($values['domain'], $space->domain);
        self::assertSame($values['version'], $space->version);
        self::assertCount(\count($values['language_codes']), $space->languageCodes);
    }

    #[DataProvider('provideMissingKeys')]
    #[Test]
    public function missingKeyThrowsException(string $key): void
    {
        $values = self::faker()->spaceResponse();
        unset($values[$key]);

        self::expectException(\InvalidArgumentException::class);

        new SpaceResponse($values);
    }

    /**
     * @return \Generator<array{0: string}>
     */
    public static function provideMissingKeys(): iterable
    {
        yield from [
            ['id'],
            ['name'],
            ['domain'],
            ['version'],
            ['language_codes'],
        ];
    }
}
