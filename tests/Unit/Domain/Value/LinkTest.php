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

namespace Storyblok\Api\Tests\Unit\Domain\Value;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Link;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class LinkTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function uuid(): void
    {
        $values = self::faker()->linkResponse();

        self::assertSame($values['uuid'], (new Link($values))->uuid->value);
    }

    #[Test]
    public function uuidKeyMustExist(): void
    {
        $values = self::faker()->linkResponse();
        unset($values['uuid']);

        self::expectException(\InvalidArgumentException::class);

        new Link($values);
    }

    #[Test]
    public function id(): void
    {
        $values = self::faker()->linkResponse();

        self::assertSame($values['id'], (new Link($values))->id->value);
    }

    #[Test]
    public function idKeyMustExist(): void
    {
        $values = self::faker()->linkResponse();
        unset($values['id']);

        self::expectException(\InvalidArgumentException::class);

        new Link($values);
    }

    #[Test]
    public function parentId(): void
    {
        $values = self::faker()->linkResponse([
            'parent_id' => 24,
        ]);

        self::assertNotNull((new Link($values))->parentId);
        self::assertSame(24, (new Link($values))->parentId->value);
    }

    #[Test]
    public function parentIdNull(): void
    {
        $values = self::faker()->linkResponse([
            'parent_id' => null,
        ]);

        self::assertNull((new Link($values))->parentId);
    }

    #[Test]
    public function parentIdKeyMustExist(): void
    {
        $values = self::faker()->linkResponse();
        unset($values['parent_id']);

        self::expectException(\InvalidArgumentException::class);

        new Link($values);
    }

    #[Test]
    public function position(): void
    {
        $values = self::faker()->linkResponse();

        self::assertSame($values['position'], (new Link($values))->position);
    }

    #[Test]
    public function positionKeyMustExist(): void
    {
        $values = self::faker()->linkResponse();
        unset($values['position']);

        self::expectException(\InvalidArgumentException::class);

        new Link($values);
    }

    #[Test]
    public function slug(): void
    {
        $values = self::faker()->linkResponse();

        self::assertSame($values['slug'], (new Link($values))->slug);
    }

    #[Test]
    public function slugKeyMustExist(): void
    {
        $values = self::faker()->linkResponse();
        unset($values['slug']);

        self::expectException(\InvalidArgumentException::class);

        new Link($values);
    }

    #[Test]
    public function path(): void
    {
        $values = self::faker()->linkResponse();

        self::assertSame($values['path'], (new Link($values))->path);
    }

    #[Test]
    public function pathKeyMustExist(): void
    {
        $values = self::faker()->linkResponse();
        unset($values['path']);

        self::expectException(\InvalidArgumentException::class);

        new Link($values);
    }

    #[Test]
    public function isFolder(): void
    {
        $values = self::faker()->linkResponse();

        self::assertSame($values['is_folder'], (new Link($values))->isFolder);
    }

    #[Test]
    public function isFolderKeyMustExist(): void
    {
        $values = self::faker()->linkResponse();
        unset($values['is_folder']);

        self::expectException(\InvalidArgumentException::class);

        new Link($values);
    }

    #[Test]
    public function isStartPage(): void
    {
        $values = self::faker()->linkResponse();

        self::assertSame($values['is_startpage'], (new Link($values))->isStartPage);
    }

    #[Test]
    public function isStartPageKeyMustExist(): void
    {
        $values = self::faker()->linkResponse();
        unset($values['is_startpage']);

        self::expectException(\InvalidArgumentException::class);

        new Link($values);
    }

    #[Test]
    public function isPublished(): void
    {
        $values = self::faker()->linkResponse();

        self::assertSame($values['published'], (new Link($values))->isPublished);
    }

    #[Test]
    public function isPublishedNull(): void
    {
        $values = self::faker()->linkResponse();
        $values['published'] = null;

        self::assertFalse((new Link($values))->isPublished);
    }

    #[Test]
    public function isPublishedKeyMustExist(): void
    {
        $values = self::faker()->linkResponse();
        unset($values['published']);

        self::expectException(\InvalidArgumentException::class);

        new Link($values);
    }

    #[Test]
    public function realPath(): void
    {
        $values = self::faker()->linkResponse();

        self::assertSame($values['real_path'], (new Link($values))->realPath);
    }

    #[Test]
    public function realPathKeyMustExist(): void
    {
        $values = self::faker()->linkResponse();
        unset($values['real_path']);

        self::expectException(\InvalidArgumentException::class);

        new Link($values);
    }

    #[Test]
    public function isPublishedWithNullAndStoryIsNotPublished(): void
    {
        $values = self::faker()->linkResponse(['published' => null]);

        self::assertFalse((new Link($values))->isPublished());
    }

    #[Test]
    public function isPublishedWithNullAndStoryIsPublished(): void
    {
        $values = self::faker()->linkResponse(['published' => true]);

        self::assertTrue((new Link($values))->isPublished());
    }

    #[Test]
    public function isPublishedWithLangAndAlternateIsPublished(): void
    {
        $faker = self::faker();
        $alternate = $faker->linkAlternateResponse([
            'lang' => $lang = $faker->randomElement(['de', 'fr']),
            'published' => true,
        ]);

        $values = $faker->linkResponse();
        unset($values['alternates']);
        $values['alternates'] = [$alternate];

        self::assertTrue((new Link($values))->isPublished($lang));
    }

    #[Test]
    public function isPublishedWithLangAndAlternateIsNotPublished(): void
    {
        $faker = self::faker();
        $alternate = $faker->linkAlternateResponse([
            'lang' => $lang = $faker->randomElement(['de', 'fr']),
            'published' => false,
        ]);

        $values = $faker->linkResponse();
        unset($values['alternates']);
        $values['alternates'] = [$alternate];

        self::assertFalse((new Link($values))->isPublished($lang));
    }

    #[Test]
    public function isFolderReturnsTrue(): void
    {
        $values = self::faker()->linkResponse(['is_folder' => true]);

        self::assertTrue((new Link($values))->isFolder());
    }

    #[Test]
    public function isFolderReturnsFalse(): void
    {
        $values = self::faker()->linkResponse(['is_folder' => false]);

        self::assertFalse((new Link($values))->isFolder());
    }

    #[Test]
    public function isStoryReturnsTrue(): void
    {
        $values = self::faker()->linkResponse(['is_folder' => false]);

        self::assertTrue((new Link($values))->isStory());
    }

    #[Test]
    public function isStoryReturnsFalse(): void
    {
        $values = self::faker()->linkResponse(['is_folder' => true]);

        self::assertFalse((new Link($values))->isStory());
    }

    #[Test]
    public function isStartPageReturnsTrue(): void
    {
        $values = self::faker()->linkResponse(['is_startpage' => true]);

        self::assertTrue((new Link($values))->isStartPage());
    }

    #[Test]
    public function isStartPageReturnsFalse(): void
    {
        $values = self::faker()->linkResponse(['is_startpage' => false]);

        self::assertFalse((new Link($values))->isStartPage());
    }

    #[Test]
    public function getNameWithLangAndAlternate(): void
    {
        $faker = self::faker();
        $alternate = $faker->linkAlternateResponse([
            'lang' => $lang = $faker->randomElement(['de', 'fr']),
            'name' => $name = $faker->word(),
        ]);

        $values = $faker->linkResponse();
        unset($values['alternates']);
        $values['alternates'] = [$alternate];

        self::assertSame($name, (new Link($values))->getName($lang));
    }

    #[Test]
    public function getNameWithNullReturnsDefaultName(): void
    {
        $faker = self::faker();

        $values = $faker->linkResponse(['name' => $name = $faker->word()]);

        self::assertSame($name, (new Link($values))->getName());
    }

    #[Test]
    public function getNameThrowsExceptionOnUnknownLanguage(): void
    {
        $faker = self::faker();

        $values = $faker->linkResponse();

        self::expectException(\InvalidArgumentException::class);

        (new Link($values))->getName('unknown');
    }

    #[Test]
    public function getSlugWithLangAndAlternate(): void
    {
        $faker = self::faker();
        $alternate = $faker->linkAlternateResponse([
            'lang' => $lang = $faker->randomElement(['de', 'fr']),
            'translated_slug' => $slug = $faker->word(),
        ]);

        $values = $faker->linkResponse();
        unset($values['alternates']);
        $values['alternates'] = [$alternate];

        self::assertSame($slug, (new Link($values))->getSlug($lang));
    }

    #[Test]
    public function getSlugWithNullReturnsDefaultName(): void
    {
        $faker = self::faker();

        $values = $faker->linkResponse(['slug' => $slug = $faker->word()]);

        self::assertSame($slug, (new Link($values))->getSlug());
    }

    #[Test]
    public function getSlugThrowsExceptionOnUnknownLanguage(): void
    {
        $faker = self::faker();

        $values = $faker->linkResponse();

        self::expectException(\InvalidArgumentException::class);

        (new Link($values))->getSlug('unknown');
    }
}
