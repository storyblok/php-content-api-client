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

namespace Storyblok\Api\Tests\Unit\Domain\Type;

use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Type\MultiLink;
use Storyblok\Api\Domain\Type\MultiLinkType;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class MultiLinkTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function fieldTypeKeyMustExist(): void
    {
        $values = self::faker()->multiLinkResponse();
        unset($values['fieldtype']);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }

    #[Test]
    public function fieldTypeInvalid(): void
    {
        $faker = self::faker();

        $values = $faker->multiLinkResponse([
            'fieldtype' => $faker->word(),
        ]);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }

    #[Test]
    public function linkTypeKeyMustExist(): void
    {
        $values = self::faker()->multiLinkResponse();
        unset($values['linktype']);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }

    #[Test]
    public function linkType(): void
    {
        $faker = self::faker();
        /** @var MultiLinkType $expected */
        $expected = $faker->randomElement(MultiLinkType::cases());

        $values = $faker->multiLinkResponse([
            'linktype' => $expected->value,
        ]);

        self::assertTrue((new MultiLink($values))->type->equals($expected));
    }

    #[Test]
    public function multiLinkOfTypeAssetMustHaveUrlKey(): void
    {
        $values = self::faker()->multiLinkResponse([
            'linktype' => MultiLinkType::Asset->value,
        ]);
        unset($values['url']);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }

    #[Test]
    public function multiLinkOfTypeAssetValidFields(): void
    {
        $faker = self::faker();
        $values = $faker->multiLinkResponse([
            'linktype' => MultiLinkType::Asset->value,
            'url' => $expected = $faker->url(),
        ]);

        self::assertSame($expected, (new MultiLink($values))->url);
    }

    #[DataProviderExternal(StringProvider::class, 'arbitrary')]
    #[Test]
    public function multiLinkOfTypeAssetWithInvalidUrl(string $value): void
    {
        $values = self::faker()->multiLinkResponse([
            'linktype' => MultiLinkType::Asset->value,
            'url' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }

    #[Test]
    public function multiLinkOfTypeEmailValidFields(): void
    {
        $faker = self::faker();
        $values = $faker->multiLinkResponse([
            'linktype' => MultiLinkType::Email->value,
            'email' => $expected = $faker->email(),
        ]);

        self::assertSame(\sprintf('mailto:%s', $expected), (new MultiLink($values))->url);
    }

    #[Test]
    public function multiLinkOfTypeEmailMustHaveEmailKey(): void
    {
        $values = self::faker()->multiLinkResponse([
            'linktype' => MultiLinkType::Email->value,
        ]);
        unset($values['email']);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }

    #[DataProviderExternal(StringProvider::class, 'arbitrary')]
    #[Test]
    public function multiLinkOfTypeEmailWithInvalidEmail(string $value): void
    {
        $values = self::faker()->multiLinkResponse([
            'linktype' => MultiLinkType::Email->value,
            'email' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }

    #[Test]
    public function multiLinkOfTypeStoryValidFields(): void
    {
        $faker = self::faker();
        $values = $faker->multiLinkResponse([
            'linktype' => MultiLinkType::Story->value,
            'id' => $expected = $faker->uuid(),
        ]);

        self::assertSame($expected, (new MultiLink($values))->id?->value);
    }

    #[Test]
    public function multiLinkOfTypeStoryMustHaveIdKey(): void
    {
        $values = self::faker()->multiLinkResponse([
            'linktype' => MultiLinkType::Story->value,
        ]);
        unset($values['id']);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }

    #[DataProviderExternal(StringProvider::class, 'arbitrary')]
    #[Test]
    public function multiLinkOfTypeStoryWithInvalidId(string $value): void
    {
        $values = self::faker()->multiLinkResponse([
            'linktype' => MultiLinkType::Story->value,
            'id' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }

    #[Test]
    public function multiLinkOfTypeUrlValidFields(): void
    {
        $faker = self::faker();
        $values = $faker->multiLinkResponse([
            'linktype' => MultiLinkType::Url->value,
            'url' => $expected = $faker->url(),
        ]);

        self::assertSame($expected, (new MultiLink($values))->url);
    }

    #[Test]
    public function multiLinkOfTypeUrlMustHaveUrlKey(): void
    {
        $values = self::faker()->multiLinkResponse([
            'linktype' => MultiLinkType::Url->value,
        ]);
        unset($values['url']);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }

    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[Test]
    public function multiLinkOfTypeUrlWithInvalidUrl(string $value): void
    {
        $values = self::faker()->multiLinkResponse([
            'linktype' => MultiLinkType::Url->value,
            'url' => $value,
        ]);

        self::expectException(\InvalidArgumentException::class);

        new MultiLink($values);
    }
}
