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
 * Represents top level query parameters which are holding simple string values.
 *
 * @author Frank Stelzer <dev@frankstelzer.de>
 */
interface QueryParameter
{
    public const string DATE_TIME_FORMAT = 'Y-m-d\TH:i:s.v\Z';

    public function getName(): string;

    public function toString(): string;
}
