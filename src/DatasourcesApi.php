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

namespace Storyblok\Api;

use Storyblok\Api\Domain\Value\Total;
use Storyblok\Api\Request\DatasourcesRequest;
use Storyblok\Api\Response\DatasourceResponse;
use Storyblok\Api\Response\DatasourcesResponse;
use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final readonly class DatasourcesApi implements DatasourcesApiInterface
{
    private const string ENDPOINT = '/v2/cdn/datasources';

    public function __construct(
        private StoryblokClientInterface $client,
    ) {
    }

    public function all(?DatasourcesRequest $request = null): DatasourcesResponse
    {
        $request ??= new DatasourcesRequest();

        $response = $this->client->request('GET', self::ENDPOINT, [
            'query' => $request->toArray(),
        ]);

        return new DatasourcesResponse(
            Total::fromHeaders($response->getHeaders()),
            $request->pagination,
            $response->toArray(),
        );
    }

    public function bySlug(string $datasourceSlug): DatasourceResponse
    {
        Assert::regex($datasourceSlug, '/^[a-z0-9-]+$/');

        $response = $this->client->request('GET', \sprintf('%s/%s', self::ENDPOINT, $datasourceSlug));

        return new DatasourceResponse($response->toArray());
    }
}
