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

namespace Storyblok\Api\Response;

use Storyblok\Api\Domain\Value\Datasource;
use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final readonly class DatasourceResponse
{
    public Datasource $datasource;

    /**
     * @param array<string, mixed> $values
     */
    public function __construct(
        array $values,
    ) {
        Assert::keyExists($values, 'datasource');
        $this->datasource = new Datasource($values['datasource']);
    }
}
