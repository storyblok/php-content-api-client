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
use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Domain\Value\Total;
use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final readonly class DatasourcesResponse
{
    /**
     * @var list<Datasource>
     */
    public array $datasources;

    /**
     * @param array<string, mixed> $values
     */
    public function __construct(
        public Total $total,
        public Pagination $pagination,
        array $values,
    ) {
        Assert::keyExists($values, 'datasources');
        $this->datasources = array_map(
            static fn (array $datasource): Datasource => new Datasource($datasource),
            $values['datasources'],
        );
    }
}
