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

namespace Storyblok\Api\Domain\Value\Dto;

use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class Pagination
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 25,
    ) {
        Assert::positiveInteger($page);
        Assert::notSame($page, 0);
        Assert::positiveInteger($perPage);
    }
}
