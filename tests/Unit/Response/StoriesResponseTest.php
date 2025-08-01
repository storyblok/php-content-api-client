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

use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Domain\Value\Total;
use Storyblok\Api\Response\StoriesResponse;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class StoriesResponseTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function stories(): void
    {
        $values = self::faker()->storiesResponse();

        self::assertCount(
            \count($values['stories']),
            (new StoriesResponse(new Total(1), new Pagination(), $values))->stories,
        );
    }

    #[Test]
    public function storiesKeyMustExist(): void
    {
        $values = self::faker()->storiesResponse();
        unset($values['stories']);

        self::expectException(\InvalidArgumentException::class);

        new StoriesResponse(new Total(1), new Pagination(), $values);
    }

    #[Test]
    public function cv(): void
    {
        $values = self::faker()->storiesResponse();

        self::assertSame(
            $values['cv'],
            (new StoriesResponse(new Total(1), new Pagination(), $values))->cv,
        );
    }

    #[Test]
    public function cvKeyMustExist(): void
    {
        $values = self::faker()->storiesResponse();
        unset($values['cv']);

        self::expectException(\InvalidArgumentException::class);

        new StoriesResponse(new Total(1), new Pagination(), $values);
    }

    #[DataProviderExternal(StringProvider::class, 'arbitrary')]
    #[Test]
    public function cvInvalid(string $value): void
    {
        $values = self::faker()->storiesResponse([
            'cv' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);
        new StoriesResponse(new Total(1), new Pagination(), $values);
    }

    #[Test]
    public function rels(): void
    {
        $values = self::faker()->storiesResponse();

        self::assertCount(
            \count($values['rels']),
            (new StoriesResponse(new Total(1), new Pagination(), $values))->rels,
        );
    }

    #[Test]
    public function relsKeyIsOptional(): void
    {
        $values = self::faker()->storiesResponse();
        unset($values['rels']);

        self::assertEmpty((new StoriesResponse(new Total(1), new Pagination(), $values))->rels);
    }

    #[Test]
    public function links(): void
    {
        $values = self::faker()->storiesResponse();

        self::assertCount(
            \count($values['links']),
            (new StoriesResponse(new Total(1), new Pagination(), $values))->links,
        );
    }

    #[Test]
    public function linksKeyMustExist(): void
    {
        $values = self::faker()->storiesResponse();
        unset($values['links']);

        self::expectException(\InvalidArgumentException::class);

        new StoriesResponse(new Total(1), new Pagination(), $values);
    }

    #[Test]
    public function relUuids(): void
    {
        $values = self::faker()->storiesResponse();

        self::assertCount(
            \count($values['rel_uuids']),
            (new StoriesResponse(new Total(1), new Pagination(), $values))->relUuids,
        );
    }

    #[Test]
    public function relUuidsKeyIsOptional(): void
    {
        $values = self::faker()->storiesResponse();
        unset($values['rel_uuids']);

        self::assertEmpty((new StoriesResponse(new Total(1), new Pagination(), $values))->relUuids);
    }
}
