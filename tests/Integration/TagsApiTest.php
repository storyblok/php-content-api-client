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
use Storyblok\Api\Response\TagsResponse;
use Storyblok\Api\TagsApi;
use Storyblok\Api\Tests\Util\FakerTrait;
use Storyblok\Api\Tests\Util\StoryblokFakeClient;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
class TagsApiTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function allTagsAreRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            ['tags' => []],
        );
        $api = new TagsApi($client);

        $response = $api->all();

        self::assertInstanceOf(TagsResponse::class, $response);
    }

    #[Test]
    public function exceptionIsThrownWhenRetrievingAllTagsFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new TagsApi($client);

        self::expectException(\Exception::class);

        $api->all();
    }
}
