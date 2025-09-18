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

/**
 * @author Frank Stelzer <dev@frankstelzer.de>
 */
final readonly class UpdatedAtGt
{
    public function __construct(
        private \DateTimeInterface $dateTime
    ) {
    }

    public function toString(): string
    {
        return $this->dateTime->format('Y-m-d\TH:i:s.v\Z');
    }
}
