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
use Storyblok\Api\Domain\Value\Uuid;
use Webmozart\Assert\Assert;

/**
 * @experimental This class is experimental and may change in future versions.
 * 
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class MultiLink
{
    public MultiLinkType $type;
    public ?Uuid $id;
    public ?string $url;

    /**
     * @param array<string, mixed> $values
     */
    public function __construct(array $values)
    {
        Assert::keyExists($values, 'fieldtype');
        Assert::same($values['fieldtype'], 'multilink');

        Assert::keyExists($values, 'linktype');
        TrimmedNonEmptyString::fromString($values['linktype']);
        $this->type = MultiLinkType::from($values['linktype']);

        $url = null;
        $id = null;

        if ($this->type->equals(MultiLinkType::Asset)) {
            Assert::keyExists($values, 'url');
            $url = TrimmedNonEmptyString::fromString($values['url'])->toString();
            Assert::startsWith($url, 'http');
        }

        if ($this->type->equals(MultiLinkType::Email)) {
            Assert::keyExists($values, 'email');
            $email = TrimmedNonEmptyString::fromString($values['email'])->toString();
            Assert::email($email);
            $url = \sprintf('mailto:%s', $email);
        }

        if ($this->type->equals(MultiLinkType::Story)) {
            Assert::keyExists($values, 'id');
            $id = new Uuid($values['id']);
        }

        if ($this->type->equals(MultiLinkType::Url)) {
            Assert::keyExists($values, 'url');
            $url = TrimmedNonEmptyString::fromString($values['url'])->toString();
        }

        $this->id = $id;
        $this->url = $url;
    }
}
