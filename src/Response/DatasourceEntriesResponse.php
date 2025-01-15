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

namespace Storyblok\Api\Response;

use Storyblok\Api\Domain\Value\DatasourceEntry;
use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Domain\Value\Total;
use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final readonly class DatasourceEntriesResponse
{
    /**
     * @var list<DatasourceEntry>
     */
    public array $datasourceEntries;

    /**
     * @param array<string, mixed> $values
     */
    public function __construct(
        public Total $total,
        public Pagination $pagination,
        array $values,
    ) {
        Assert::keyExists($values, 'datasource_entries');
        $this->datasourceEntries = array_map(
            static fn (array $entry): DatasourceEntry => new DatasourceEntry($entry),
            $values['datasource_entries'],
        );
    }
}
