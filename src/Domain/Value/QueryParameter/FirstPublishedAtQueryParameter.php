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

final readonly class FirstPublishedAtQueryParameter extends DateQueryParameter
{
    public const string FIRST_PUBLISHED_AT_GT = 'first_published_at_gt';
    public const string FIRST_PUBLISHED_AT_LT = 'first_published_at_lt';

    public function __construct(\DateTimeInterface $publishedAt, Operator $operator)
    {
        $name = match ($operator->value) {
            'lt' => self::FIRST_PUBLISHED_AT_LT,
            default => self::FIRST_PUBLISHED_AT_GT,
        };

        parent::__construct($name, $publishedAt->format('Y-m-d H:i'));
    }
}
