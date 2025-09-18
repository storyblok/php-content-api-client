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

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\QueryParameter\FirstPublishedAtGt;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Frank Stelzer <dev@frankstelzer.de>
 */
class FirstPublishedAtGtTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function valueToString(): void
    {
        $value = self::faker()->dateTime();
        $expectedValue = $value->format('Y-m-d\TH:i:s.v\Z');

        $valueObject = new FirstPublishedAtGt($value);
        self::assertSame($expectedValue, $valueObject->toString());
    }
}
