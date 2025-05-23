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

namespace Storyblok\Api\Domain\Value\Filter\Filters;

use OskarStark\Value\TrimmedNonEmptyString;
use Storyblok\Api\Domain\Value\Filter\Operation;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class NotLikeFilter extends Filter
{
    public function __construct(
        private string $field,
        private string $value,
    ) {
        TrimmedNonEmptyString::fromString($field);
        TrimmedNonEmptyString::fromString($value);
    }

    public function toArray(): array
    {
        return [
            $this->field => [
                self::operation()->value => $this->value,
            ],
        ];
    }

    public function field(): string
    {
        return $this->field;
    }

    public static function operation(): Operation
    {
        return Operation::NotLike;
    }
}
