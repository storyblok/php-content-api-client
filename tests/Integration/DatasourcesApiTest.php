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
use Storyblok\Api\DatasourcesApi;
use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Request\DatasourcesRequest;
use Storyblok\Api\Response\DatasourceResponse;
use Storyblok\Api\Response\DatasourcesResponse;
use Storyblok\Api\Tests\Util\FakerTrait;
use Storyblok\Api\Tests\Util\StoryblokFakeClient;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
class DatasourcesApiTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function allDatasourcesAreRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->datasourcesResponse(),
            ['total' => 10],
        );
        $api = new DatasourcesApi($client);

        $response = $api->all(new DatasourcesRequest(pagination: new Pagination(1, 10)));

        self::assertInstanceOf(DatasourcesResponse::class, $response);
    }

    #[Test]
    public function datasourceIsRetrievedBySlugSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            ['datasource' => self::faker()->datasourceResponse()],
        );
        $api = new DatasourcesApi($client);

        $response = $api->bySlug('test-slug');

        self::assertInstanceOf(DatasourceResponse::class, $response);
    }

    #[Test]
    public function exceptionIsThrownWhenRetrievingAllDatasourcesFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new DatasourcesApi($client);

        self::expectException(\Exception::class);

        $api->all(new DatasourcesRequest(pagination: new Pagination(1, 10)));
    }

    #[Test]
    public function exceptionIsThrownWhenRetrievingDatasourceBySlugFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new DatasourcesApi($client);

        self::expectException(\Exception::class);

        $api->bySlug('test-slug');
    }
}
