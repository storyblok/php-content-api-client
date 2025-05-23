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

use Storyblok\Api\Request\DatasourceEntriesRequest;
use Storyblok\Api\Response\DatasourceEntriesResponse;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
interface DatasourceEntriesApiInterface
{
    public function all(?DatasourceEntriesRequest $request = null): DatasourceEntriesResponse;

    public function allByDatasource(string $datasource, ?DatasourceEntriesRequest $request = null): DatasourceEntriesResponse;

    public function allByDimension(string $dimension, ?DatasourceEntriesRequest $request = null): DatasourceEntriesResponse;

    public function allByDatasourceDimension(string $datasource, string $dimension, ?DatasourceEntriesRequest $request = null): DatasourceEntriesResponse;
}
