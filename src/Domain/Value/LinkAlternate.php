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

use OskarStark\Value\TrimmedNonEmptyString;
use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class LinkAlternate
{
    public string $lang;
    public ?string $name;
    public string $path;
    public string $slug;
    public bool $published;

    /**
     * @param array<string, mixed> $values
     */
    public function __construct(array $values)
    {
        Assert::keyExists($values, 'lang');
        $this->lang = TrimmedNonEmptyString::fromString($values['lang'])->toString();

        Assert::keyExists($values, 'name');

        if (null !== $values['name']) {
            $name = TrimmedNonEmptyString::fromString($values['name'])->toString();
        }

        $this->name = $name ?? null;

        Assert::keyExists($values, 'path');
        $this->path = TrimmedNonEmptyString::fromString($values['path'])->toString();

        $slug = null;

        if (\array_key_exists('translated_slug', $values)) {
            $slug = TrimmedNonEmptyString::fromString($values['translated_slug'])->toString();
        }

        $this->slug = $slug ?? $this->path;

        Assert::keyExists($values, 'published');
        $this->published = true === $values['published'];
    }

    public function isPublished(): bool
    {
        return $this->published;
    }
}
