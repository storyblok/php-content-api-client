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

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Link;
use Storyblok\Api\Domain\Value\Total;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class TotalTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function fromHeaders(): void
    {
        $headers = ['total' => ['5']];

        self::assertSame((int) $headers['total'][0], Total::fromHeaders($headers)->value);
    }

    #[Test]
    public function totalKeyMustExist(): void
    {
        self::expectException(\InvalidArgumentException::class);

        new Link([]);
    }

    #[Test]
    public function totalKeyMustContainExactlyOneItem(): void
    {
        self::expectException(\InvalidArgumentException::class);

        new Link(['total' => []]);
    }
}
