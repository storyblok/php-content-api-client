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

final readonly class UpdatedAtQueryParameter extends DateQueryParameter
{
    public const string UPDATED_AT_GT = 'updated_at_gt';
    public const string UPDATED_AT_LT = 'updated_at_lt';

    public function __construct(\DateTimeInterface $publishedAt, Operator $operator)
    {
        $name = match ($operator->value) {
            'lt' => self::UPDATED_AT_LT,
            default => self::UPDATED_AT_GT,
        };

        parent::__construct($name, $publishedAt->format('Y-m-d H:i'));
    }
}
