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

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Domain\Value\Total;
use Storyblok\Api\Response\LinksResponse;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class LinksResponseTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function links(): void
    {
        $values = self::faker()->linksResponse();

        self::assertCount(
            \count($values['links']),
            (new LinksResponse(new Total(1), new Pagination(), $values))->links,
        );
    }

    #[Test]
    public function linksKeyMustExist(): void
    {
        self::expectException(\InvalidArgumentException::class);

        new LinksResponse(new Total(1), new Pagination(), []);
    }
}
