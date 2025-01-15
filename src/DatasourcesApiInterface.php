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

namespace Storyblok\Api;

use Storyblok\Api\Request\DatasourcesRequest;
use Storyblok\Api\Response\DatasourceResponse;
use Storyblok\Api\Response\DatasourcesResponse;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
interface DatasourcesApiInterface
{
    public function all(?DatasourcesRequest $request = null): DatasourcesResponse;

    public function bySlug(string $datasourceSlug): DatasourceResponse;
}
