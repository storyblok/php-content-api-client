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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Filter;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Filter\Operation;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
abstract class FilterTestCase extends TestCase
{
    use FakerTrait;

    #[Test]
    public function isSameOperation(): void
    {
        self::assertSame(
            static::operation()->value,
            (static::filterClass())::operation()->value,
        );
    }

    abstract protected static function operation(): Operation;

    /**
     * @return class-string
     */
    abstract protected static function filterClass(): string;
}
