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

namespace Storyblok\Api\Exception;

use Storyblok\Api\Domain\Value\Filter\Filters\Filter;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
class FilterCanNotBeUsedMultipleTimes extends \InvalidArgumentException
{
    public static function fromFilter(Filter $filter): self
    {
        return new self(\sprintf(
            'Filter "%s" can not be used multiple times',
            $filter::class,
        ));
    }
}
