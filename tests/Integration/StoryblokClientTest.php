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

namespace Storyblok\Api\Tests\Integration;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Tests\Util\FakerTrait;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class StoryblokClientTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function requestUrlMustStartWithTrailingSlash(): void
    {
        $client = self::createClient(new MockResponse());

        self::expectException(\InvalidArgumentException::class);

        $client->request('GET', self::faker()->word());
    }

    #[Test]
    public function requestUrlMustNotStartWithHttp(): void
    {
        $client = self::createClient(new MockResponse());

        self::expectException(\InvalidArgumentException::class);

        $client->request('GET', self::faker()->url());
    }

    public static function createClient(ResponseInterface $response): StoryblokClient
    {
        return new StoryblokClient(
            baseUri: 'https://api.storyblok.com/',
            token: 'test-token',
        );
    }
}
