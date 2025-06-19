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
use Storyblok\Api\Domain\Value\Id;
use Webmozart\Assert\Assert;
use function Symfony\Component\String\u;

/**
 * @experimental This class is experimental and may change in future versions.
 *
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class Asset
{
    public Id $id;
    public string $url;
    public string $name;
    public string $extension;
    public ?string $alt;
    public ?string $title;
    public ?string $focus;
    public ?string $source;
    public ?string $copyright;
    public bool $isExternalUrl;
    public int $width;
    public int $height;
    public Orientation $orientation;

    /**
     * @param array<string, mixed> $values
     */
    public function __construct(array $values)
    {
        Assert::keyExists($values, 'id');
        Assert::integer($values['id']);
        $this->id = new Id($values['id']);

        Assert::keyExists($values, 'filename');
        $this->url = TrimmedNonEmptyString::fromString($values['filename'])->toString();

        Assert::keyExists($values, 'is_external_url');
        $this->isExternalUrl = true === $values['is_external_url'];

        $alt = null;

        if (\array_key_exists('alt', $values) && '' !== $values['alt'] && null !== $values['alt']) {
            $alt = TrimmedNonEmptyString::fromString($values['alt'])->toString();
        }

        $this->alt = $alt;

        $title = null;

        if (\array_key_exists('title', $values) && '' !== $values['title'] && null !== $values['title']) {
            $title = TrimmedNonEmptyString::fromString($values['title'])->toString();
        }

        $this->title = $title;

        $focus = null;

        if (\array_key_exists('focus', $values) && '' !== $values['focus'] && null !== $values['focus']) {
            $focus = TrimmedNonEmptyString::fromString($values['focus'])->toString();
        }

        $this->focus = $focus;

        $source = null;

        if (\array_key_exists('source', $values) && '' !== $values['source'] && null !== $values['source']) {
            $source = TrimmedNonEmptyString::fromString($values['source'])->toString();
        }

        $this->source = $source;

        $copyright = null;

        if (\array_key_exists('copyright', $values) && '' !== $values['copyright'] && null !== $values['copyright']) {
            $copyright = TrimmedNonEmptyString::fromString($values['copyright'])->toString();
        }

        $this->copyright = $copyright;

        $this->extension = pathinfo($this->url, \PATHINFO_EXTENSION);
        $this->name = pathinfo($this->url, \PATHINFO_FILENAME);

        $dimensions = u($this->url)->match('/(?P<width>\d+)x(?P<height>\d+)/');

        $width = 0;

        if (\array_key_exists('width', $dimensions) && [] !== $dimensions['width']) {
            $width = (int) $dimensions['width'];
        }

        $this->width = $width;

        $height = 0;

        if (\array_key_exists('height', $dimensions) && [] !== $dimensions['height']) {
            $height = (int) $dimensions['height'];
        }

        $this->height = $height;

        $orientation = Orientation::Unknown;

        if (0 < $this->width && 0 < $this->height) {
            $ratio = $this->width / $this->height;

            $orientation = Orientation::Portrait;

            if (\abs(1 - $ratio) <= 0.1) {
                $orientation = Orientation::Square;
            } elseif ($this->width > $this->height) {
                $orientation = Orientation::Landscape;
            }
        }

        $this->orientation = $orientation;
    }
}
