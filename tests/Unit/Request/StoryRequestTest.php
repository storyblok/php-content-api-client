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

namespace Storyblok\Api\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Dto\Version;
use Storyblok\Api\Request\StoryRequest;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class StoryRequestTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function toArray(): void
    {
        $request = new StoryRequest(
            language: $language = self::faker()->word(),
            version: $version = Version::Published,
        );

        self::assertSame([
            'language' => $language,
            'version' => $version->value,
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function toArrayWithDefaults(): void
    {
        $request = new StoryRequest();

        self::assertSame([
            'language' => 'default',
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function toArrayWithVersion(): void
    {
        $request = new StoryRequest(
            version: $version = Version::Published,
        );

        self::assertSame([
            'language' => 'default',
            'version' => $version->value,
        ], $request->toArray());
    }
}
