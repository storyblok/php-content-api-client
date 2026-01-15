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

namespace Storyblok\Api\Domain\Value\Resolver;

use Webmozart\Assert\Assert;

final readonly class ResolveLinks
{
    public function __construct(
        public ?LinkType $type = null,
        public LinkLevel $level = LinkLevel::Default,
    ) {
    }

    /**
     * @param array{
     *     type?: null|string,
     *     level?: int,
     * } $data
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'type');
        Assert::keyExists($data, 'level');

        return new self(
            type: $data['type'] ? LinkType::from($data['type']) : null,
            level: LinkLevel::from($data['level']),
        );
    }

    /**
     * @return array{
     *     type: null|string,
     *     level: int,
     * }
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type?->value,
            'level' => $this->level->value,
        ];
    }
}
