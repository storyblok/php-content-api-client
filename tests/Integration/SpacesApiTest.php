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

namespace Storyblok\Api\Tests\Integration;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Space;
use Storyblok\Api\Response\SpaceResponse;
use Storyblok\Api\SpacesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Tests\Util\FakerTrait;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class SpacesApiTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function me(): void
    {
        $client = self::createClient([
            'space' => self::faker()->spaceResponse([
                'id' => 123,
                'name' => 'foo',
                'domain' => 'bar',
                'version' => 1,
                'language_codes' => ['de', 'en'],
            ]),
        ]);
        $api = new SpacesApi($client);

        $response = $api->me();

        self::assertInstanceOf(SpaceResponse::class, $response);
        self::assertInstanceOf(Space::class, $space = $response->space);

        self::assertSame(123, $space->id->value);
        self::assertSame('foo', $space->name);
        self::assertSame('bar', $space->domain);
        self::assertSame(1, $space->version);
        self::assertSame(['de', 'en'], $space->languageCodes);
    }

    #[Test]
    public function meThrowsExceptionIfSpaceIsMissing(): void
    {
        $client = self::createClient([]);
        $api = new SpacesApi($client);

        self::expectException(\InvalidArgumentException::class);

        $api->me();
    }

    /**
     * @param array<string, mixed> $response
     */
    public static function createClient(array $response): StoryblokClient
    {
        $client = new StoryblokClient(
            baseUri: 'https://example.com/',
            token: 'token',
        );

        $client->withHttpClient(new MockHttpClient(
            new JsonMockResponse($response),
            'https://api.storyblok.com/',
        ));

        return $client;
    }
}
