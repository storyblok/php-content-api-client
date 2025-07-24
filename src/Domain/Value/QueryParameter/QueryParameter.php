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

use OskarStark\Value\TrimmedNonEmptyString;

/**
 * Represents top level query parameters which are holding simple string values.
 *
 * @author Frank Stelzer <dev@frankstelzer.de>
 */
abstract readonly class QueryParameter
{
    public function __construct(
        public string $name,
        public string $value,
    ) {
        $this->validateName($name);
        $this->validateValue($value);
    }

    protected function validateName(string $name): void
    {
        TrimmedNonEmptyString::fromString($name);
    }

    protected function validateValue(string $value): void
    {
        TrimmedNonEmptyString::fromString($value);
    }
}
