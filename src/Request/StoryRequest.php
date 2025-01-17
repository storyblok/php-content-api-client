<?php

declare(strict_types=1);

/**
 * This file is part of Storyblok-Api.
 *
 * (c) SensioLabs Deutschland <info@sensiolabs.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Storyblok\Api\Request;

use Storyblok\Api\Domain\Value\Dto\Version;
use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class StoryRequest
{
    public function __construct(
        public string $language = 'default',
        public ?Version $version = null,
    ) {
        Assert::stringNotEmpty($language);
    }

    /**
     * @return array{
     *     language: string,
     *     version?: string,
     * }
     */
    public function toArray(): array
    {
        $array = [
            'language' => $this->language,
        ];

        if (null !== $this->version) {
            $array['version'] = $this->version->value;
        }

        return $array;
    }
}
