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

namespace Storyblok\Api\Domain\Value;

use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class Total
{
    public function __construct(
        public int $value,
    ) {
        Assert::greaterThanEq($value, 0);
    }

    /**
     * @param array<string, array<string>> $headers
     */
    public static function fromHeaders(array $headers): self
    {
        Assert::keyExists($headers, 'total');
        Assert::count($headers['total'], 1);

        return new self((int) $headers['total'][0]);
    }
}
