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

namespace Storyblok\Api\Domain\Value\QueryParameter;

use Webmozart\Assert\Assert;

/**
 * Represents top level query parameters which are holding simple string values.
 *
 * @author Frank Stelzer <dev@frankstelzer.de>
 */
abstract readonly class DateQueryParameter extends QueryParameter
{
    protected function validateValue(string $value): void
    {
        parent::validateValue($value);

        Assert::regex(
            $value,
            '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/',
            \sprintf('The date must be in the format YYYY-MM-DD HH:MM, given: %s', $value),
        );
    }
}
