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

use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Domain\Value\Link;
use Storyblok\Api\Domain\Value\Total;
use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class LinksResponse
{
    /**
     * @var list<Link>
     */
    public array $links;

    /**
     * @param array<string, mixed> $values
     */
    public function __construct(
        public Total $total,
        public Pagination $pagination,
        array $values,
    ) {
        Assert::keyExists($values, 'links');
        $this->links = array_values(array_map(static fn (array $values): Link => new Link($values), $values['links']));
    }
}
