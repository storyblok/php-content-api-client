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

namespace Storyblok\Api\Domain\Type;

use OskarStark\Value\TrimmedNonEmptyString;
use Webmozart\Assert\Assert;

/**
 * @experimental This class is experimental and may change in future versions.
 *
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class RichText
{
    public string $type;

    /**
     * @var list<mixed[]>
     */
    public array $content;

    /**
     * @param array<string, mixed> $values
     */
    public function __construct(array $values)
    {
        Assert::keyExists($values, 'type');
        $this->type = TrimmedNonEmptyString::fromString($values['type'])->toString();
        Assert::same($this->type, 'doc');

        Assert::keyExists($values, 'content');
        Assert::isList($values['content']);
        $this->content = $values['content'];
    }

    /**
     * @return array{
     *     type: string,
     *     content: list<mixed[]>,
     * }
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'content' => $this->content,
        ];
    }
}
