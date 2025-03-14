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

namespace Storyblok\Api\Tests\Unit\Response;

use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Response\StoryResponse;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class StoryResponseTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function storyKeyMustExist(): void
    {
        $values = self::faker()->storyResponse();
        unset($values['story']);

        self::expectException(\InvalidArgumentException::class);

        new StoryResponse($values);
    }

    #[Test]
    public function cv(): void
    {
        $values = self::faker()->storyResponse();

        self::assertSame($values['cv'], (new StoryResponse($values))->cv);
    }

    #[Test]
    public function cvKeyMustExist(): void
    {
        $values = self::faker()->storyResponse();
        unset($values['cv']);

        self::expectException(\InvalidArgumentException::class);

        new StoryResponse($values);
    }

    #[DataProviderExternal(StringProvider::class, 'arbitrary')]
    #[Test]
    public function cvInvalid(string $value): void
    {
        $values = self::faker()->storyResponse([
            'cv' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);
        new StoryResponse($values);
    }

    #[Test]
    public function rels(): void
    {
        $values = self::faker()->storyResponse();

        self::assertCount(\count($values['rels']), (new StoryResponse($values))->rels);
    }

    #[Test]
    public function relsKeyMustExist(): void
    {
        $values = self::faker()->storyResponse();
        unset($values['rels']);

        self::expectException(\InvalidArgumentException::class);

        new StoryResponse($values);
    }

    #[Test]
    public function links(): void
    {
        $values = self::faker()->storyResponse();

        self::assertCount(\count($values['links']), (new StoryResponse($values))->links);
    }

    #[Test]
    public function linksKeyMustExist(): void
    {
        $values = self::faker()->storyResponse();
        unset($values['links']);

        self::expectException(\InvalidArgumentException::class);

        new StoryResponse($values);
    }
}
