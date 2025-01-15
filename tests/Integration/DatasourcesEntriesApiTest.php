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

use PHPUnit\Framework\TestCase;
use Storyblok\Api\DatasourceEntriesApi;
use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Request\DatasourceEntriesRequest;
use Storyblok\Api\Response\DatasourceEntriesResponse;
use Storyblok\Api\Tests\Util\FakerTrait;
use Storyblok\Api\Tests\Util\StoryblokFakeClient;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
class DatasourcesEntriesApiTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function allDatasourceEntriesAreRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->datasourceEntriesResponse(),
            ['total' => 10],
        );
        $api = new DatasourceEntriesApi($client);

        $response = $api->all(new DatasourceEntriesRequest(pagination: new Pagination(1, 10)));

        self::assertInstanceOf(DatasourceEntriesResponse::class, $response);
    }

    /**
     * @test
     */
    public function allDatasourceEntriesByDatasourceAreRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->datasourceEntriesResponse(),
            ['total' => 10],
        );
        $api = new DatasourceEntriesApi($client);

        $response = $api->allByDatasource(
            'test-datasource',
            new DatasourceEntriesRequest(pagination: new Pagination(1, 10)),
        );

        self::assertInstanceOf(DatasourceEntriesResponse::class, $response);
    }

    /**
     * @test
     */
    public function allDatasourceEntriesByDimensionAreRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->datasourceEntriesResponse(),
            ['total' => 10],
        );
        $api = new DatasourceEntriesApi($client);

        $response = $api->allByDimension(
            'test-dimension',
            new DatasourceEntriesRequest(pagination: new Pagination(1, 10)),
        );

        self::assertInstanceOf(DatasourceEntriesResponse::class, $response);
    }

    /**
     * @test
     */
    public function allDatasourceEntriesByDatasourceDimensionAreRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->datasourceEntriesResponse(),
            ['total' => 10],
        );
        $api = new DatasourceEntriesApi($client);

        $response = $api->allByDatasourceDimension(
            'test-datasource',
            'test-dimension',
            new DatasourceEntriesRequest(pagination: new Pagination(1, 10)),
        );

        self::assertInstanceOf(DatasourceEntriesResponse::class, $response);
    }

    /**
     * @test
     */
    public function exceptionIsThrownWhenRetrievingAllDatasourceEntriesFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new DatasourceEntriesApi($client);

        self::expectException(\Exception::class);

        $api->all(new DatasourceEntriesRequest(pagination: new Pagination(1, 10)));
    }

    /**
     * @test
     */
    public function exceptionIsThrownWhenRetrievingDatasourceEntriesByDatasourceFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new DatasourceEntriesApi($client);

        self::expectException(\Exception::class);

        $api->allByDatasource(
            'test-datasource',
            new DatasourceEntriesRequest(pagination: new Pagination(1, 10)),
        );
    }

    /**
     * @test
     */
    public function exceptionIsThrownWhenRetrievingDatasourceEntriesByDimensionFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new DatasourceEntriesApi($client);

        self::expectException(\Exception::class);

        $api->allByDimension(
            'test-dimension',
            new DatasourceEntriesRequest(pagination: new Pagination(1, 10)),
        );
    }

    /**
     * @test
     */
    public function exceptionIsThrownWhenRetrievingDatasourceEntriesByDatasourceDimensionFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new DatasourceEntriesApi($client);

        self::expectException(\Exception::class);

        $api->allByDatasourceDimension(
            'test-datasource',
            'test-dimension',
            new DatasourceEntriesRequest(pagination: new Pagination(1, 10)),
        );
    }
}
