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

namespace Storyblok\Api\Tests\Unit\Util;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Safe\DateTimeImmutable;
use Storyblok\Api\Domain\Type\Asset;
use Storyblok\Api\Domain\Type\Editable;
use Storyblok\Api\Domain\Type\MultiLink;
use Storyblok\Api\Domain\Type\MultiLinkType;
use Storyblok\Api\Domain\Type\Orientation;
use Storyblok\Api\Domain\Type\RichText;
use Storyblok\Api\Domain\Value\Uuid;
use Storyblok\Api\Tests\Util\FakerTrait;
use Storyblok\Api\Util\ValueObjectTrait;

final class ValueObjectTraitTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function one(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::one as public;
            }
        };

        $values = ['key' => [['id' => 1, 'filename' => 'test.jpg']]];

        $result = $class::one($values, 'key', Asset::class);

        self::assertInstanceOf(Asset::class, $result);
    }

    #[Test]
    public function oneThrowsInvalidArgumentExceptionWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::one as public;
            }
        };

        $values = ['key' => [['id' => 1, 'filename' => 'test.jpg']]];

        $this->expectException(\InvalidArgumentException::class);

        $class::one($values, 'non-existent-key', Asset::class);
    }

    #[Test]
    public function oneThrowsInvalidArgumentExceptionWhenValueIsNotList(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::one as public;
            }
        };

        $values = ['key' => 'not-a-list'];

        $this->expectException(\InvalidArgumentException::class);

        $class::one($values, 'key', Asset::class);
    }

    #[Test]
    public function oneThrowsInvalidArgumentExceptionWhenListDoesNotHaveExactlyOneItem(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::one as public;
            }
        };

        $values = ['key' => [['id' => 1, 'filename' => 'test.jpg'], ['id' => 2, 'filename' => 'test2.jpg']]];

        $this->expectException(\InvalidArgumentException::class);

        $class::one($values, 'key', Asset::class);
    }

    #[Test]
    public function list(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::list as public;
            }
        };

        $values = ['key' => [
            ['id' => 1, 'filename' => 'test1.jpg'],
            ['id' => 2, 'filename' => 'test2.jpg'],
        ]];

        $result = $class::list($values, 'key', Asset::class);

        self::assertCount(2, $result);
        self::assertInstanceOf(Asset::class, $result[0]);
        self::assertInstanceOf(Asset::class, $result[1]);
    }

    #[Test]
    public function listReturnsEmptyArrayWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::list as public;
            }
        };

        $values = [];

        $result = $class::list($values, 'non-existent-key', Asset::class);

        self::assertSame([], $result);
    }

    #[Test]
    public function listWithCount(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::list as public;
            }
        };

        $values = ['key' => [
            ['id' => 1, 'filename' => 'test1.jpg'],
            ['id' => 2, 'filename' => 'test2.jpg'],
        ]];

        $result = $class::list($values, 'key', Asset::class, count: 2);

        self::assertCount(2, $result);
    }

    #[Test]
    public function listWithCountThrowsExceptionWhenCountDoesNotMatch(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::list as public;
            }
        };

        $values = ['key' => [
            ['id' => 1, 'filename' => 'test1.jpg'],
        ]];

        $this->expectException(\InvalidArgumentException::class);

        $class::list($values, 'key', Asset::class, count: 2);
    }

    #[Test]
    public function listWithMinCount(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::list as public;
            }
        };

        $values = ['key' => [
            ['id' => 1, 'filename' => 'test1.jpg'],
            ['id' => 2, 'filename' => 'test2.jpg'],
        ]];

        $result = $class::list($values, 'key', Asset::class, min: 1);

        self::assertCount(2, $result);
    }

    #[Test]
    public function listWithMinCountThrowsExceptionWhenBelowMin(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::list as public;
            }
        };

        $values = ['key' => [
            ['id' => 1, 'filename' => 'test1.jpg'],
        ]];

        $this->expectException(\InvalidArgumentException::class);

        $class::list($values, 'key', Asset::class, min: 2);
    }

    #[Test]
    public function listWithMaxCount(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::list as public;
            }
        };

        $values = ['key' => [
            ['id' => 1, 'filename' => 'test1.jpg'],
        ]];

        $result = $class::list($values, 'key', Asset::class, max: 2);

        self::assertCount(1, $result);
    }

    #[Test]
    public function listWithMaxCountThrowsExceptionWhenAboveMax(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::list as public;
            }
        };

        $values = ['key' => [
            ['id' => 1, 'filename' => 'test1.jpg'],
            ['id' => 2, 'filename' => 'test2.jpg'],
            ['id' => 3, 'filename' => 'test3.jpg'],
        ]];

        $this->expectException(\InvalidArgumentException::class);

        $class::list($values, 'key', Asset::class, max: 2);
    }

    #[Test]
    public function listThrowsExceptionWhenCountUsedWithMinOrMax(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::list as public;
            }
        };

        $values = ['key' => [['id' => 1, 'filename' => 'test1.jpg']]];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You can not use $count with $min or $max.');

        $class::list($values, 'key', Asset::class, min: 1, count: 1);
    }

    #[Test]
    public function listThrowsExceptionWhenValueIsNotList(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::list as public;
            }
        };

        $values = ['key' => 'not-a-list'];

        $this->expectException(\InvalidArgumentException::class);

        $class::list($values, 'key', Asset::class);
    }

    #[Test]
    public function enum(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::enum as public;
            }
        };

        $values = ['key' => 'square'];

        $result = $class::enum($values, 'key', Orientation::class);

        self::assertSame(Orientation::Square, $result);
    }

    #[Test]
    public function enumWithDefault(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::enum as public;
            }
        };

        $values = ['key' => 'invalid-value'];

        $result = $class::enum($values, 'key', Orientation::class, Orientation::Unknown);

        self::assertSame(Orientation::Unknown, $result);
    }

    #[Test]
    public function enumThrowsExceptionWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::enum as public;
            }
        };

        $values = [];

        $this->expectException(\InvalidArgumentException::class);

        $class::enum($values, 'non-existent-key', Orientation::class);
    }

    #[Test]
    public function enumThrowsExceptionWhenClassIsNotEnum(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::enum as public;
            }
        };

        $values = ['key' => 'value'];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The class "stdClass" is not an enum.');

        $class::enum($values, 'key', \stdClass::class);
    }

    #[Test]
    public function enumThrowsValueErrorWhenInvalidValueAndNoDefault(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::enum as public;
            }
        };

        $values = ['key' => 'invalid-value'];

        $this->expectException(\ValueError::class);

        $class::enum($values, 'key', Orientation::class);
    }

    #[Test]
    public function enumWithAllowedSubset(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::enum as public;
            }
        };

        $values = ['key' => 'square'];

        $result = $class::enum($values, 'key', Orientation::class, null, [Orientation::Square, Orientation::Portrait]);

        self::assertSame(Orientation::Square, $result);
    }

    #[Test]
    public function enumWithAllowedSubsetThrowsExceptionWhenNotInSubset(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::enum as public;
            }
        };

        $values = ['key' => 'landscape'];

        $this->expectException(\InvalidArgumentException::class);

        $class::enum($values, 'key', Orientation::class, null, [Orientation::Square, Orientation::Portrait]);
    }

    #[Test]
    public function dateTimeImmutable(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::DateTimeImmutable as public;
            }
        };

        $values = ['key' => '2023-01-01T00:00:00Z'];

        $result = $class::DateTimeImmutable($values, 'key');

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2023-01-01T00:00:00+00:00', $result->format('c'));
    }

    #[Test]
    public function dateTimeImmutableWithTimezone(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::DateTimeImmutable as public;
            }
        };

        $values = ['key' => '2023-01-01T00:00:00'];
        $timezone = new \DateTimeZone('Europe/Berlin');

        $result = $class::DateTimeImmutable($values, 'key', $timezone);

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('Europe/Berlin', $result->getTimezone()->getName());
    }

    #[Test]
    public function dateTimeImmutableThrowsExceptionWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::DateTimeImmutable as public;
            }
        };

        $values = [];

        $this->expectException(\InvalidArgumentException::class);

        $class::DateTimeImmutable($values, 'non-existent-key');
    }

    #[Test]
    public function uuid(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::Uuid as public;
            }
        };

        $values = ['key' => '550e8400-e29b-41d4-a716-446655440000'];

        $result = $class::Uuid($values, 'key');

        self::assertInstanceOf(Uuid::class, $result);
        self::assertSame('550e8400-e29b-41d4-a716-446655440000', $result->value);
    }

    #[Test]
    public function multiLink(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::MultiLink as public;
            }
        };

        $values = ['key' => [
            'fieldtype' => 'multilink',
            'linktype' => 'url',
            'url' => 'https://example.com',
        ]];

        $result = $class::MultiLink($values, 'key');

        self::assertInstanceOf(MultiLink::class, $result);
        self::assertSame(MultiLinkType::Url, $result->type);
        self::assertSame('https://example.com', $result->url);
    }

    #[Test]
    public function multiLinkThrowsExceptionWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::MultiLink as public;
            }
        };

        $values = [];

        $this->expectException(\InvalidArgumentException::class);

        $class::MultiLink($values, 'non-existent-key');
    }

    #[Test]
    public function multiLinkThrowsExceptionWhenValueIsNotArray(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::MultiLink as public;
            }
        };

        $values = ['key' => 'not-an-array'];

        $this->expectException(\InvalidArgumentException::class);

        $class::MultiLink($values, 'key');
    }

    #[Test]
    public function asset(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::Asset as public;
            }
        };

        $values = ['key' => ['id' => 1, 'filename' => 'test.jpg']];

        $result = $class::Asset($values, 'key');

        self::assertInstanceOf(Asset::class, $result);
    }

    #[Test]
    public function assetThrowsExceptionWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::Asset as public;
            }
        };

        $values = [];

        $this->expectException(\InvalidArgumentException::class);

        $class::Asset($values, 'non-existent-key');
    }

    #[Test]
    public function assetThrowsExceptionWhenValueIsNotArray(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::Asset as public;
            }
        };

        $values = ['key' => 'not-an-array'];

        $this->expectException(\InvalidArgumentException::class);

        $class::Asset($values, 'key');
    }

    #[Test]
    public function richText(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::RichText as public;
            }
        };

        $values = ['key' => [
            'type' => 'doc',
            'content' => [
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Hello world']]],
            ],
        ]];

        $result = $class::RichText($values, 'key');

        self::assertInstanceOf(RichText::class, $result);
        self::assertSame('doc', $result->type);
    }

    #[Test]
    public function richTextThrowsExceptionWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::RichText as public;
            }
        };

        $values = [];

        $this->expectException(\InvalidArgumentException::class);

        $class::RichText($values, 'non-existent-key');
    }

    #[Test]
    public function richTextThrowsExceptionWhenValueIsNotArray(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::RichText as public;
            }
        };

        $values = ['key' => 'not-an-array'];

        $this->expectException(\InvalidArgumentException::class);

        $class::RichText($values, 'key');
    }

    #[Test]
    public function nullOrRichText(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrRichText as public;
            }
        };

        $values = ['key' => [
            'type' => 'doc',
            'content' => [
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Hello world']]],
            ],
        ]];

        $result = $class::nullOrRichText($values, 'key');

        self::assertInstanceOf(RichText::class, $result);
    }

    #[Test]
    public function nullOrRichTextReturnsNullWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrRichText as public;
            }
        };

        $values = [];

        $result = $class::nullOrRichText($values, 'non-existent-key');

        self::assertNull($result);
    }

    #[Test]
    public function nullOrRichTextReturnsNullWhenValueIsNull(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrRichText as public;
            }
        };

        $values = ['key' => null];

        $result = $class::nullOrRichText($values, 'key');

        self::assertNull($result);
    }

    #[Test]
    public function nullOrRichTextReturnsNullWhenValueIsEmptyArray(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrRichText as public;
            }
        };

        $values = ['key' => []];

        $result = $class::nullOrRichText($values, 'key');

        self::assertNull($result);
    }

    #[Test]
    public function zeroOrInteger(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::zeroOrInteger as public;
            }
        };

        $values = ['key' => '42'];

        $result = $class::zeroOrInteger($values, 'key');

        self::assertSame(42, $result);
    }

    #[Test]
    public function zeroOrIntegerReturnsZeroWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::zeroOrInteger as public;
            }
        };

        $values = [];

        $result = $class::zeroOrInteger($values, 'non-existent-key');

        self::assertSame(0, $result);
    }

    #[Test]
    public function zeroOrIntegerReturnsZeroWhenValueIsEmptyArray(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::zeroOrInteger as public;
            }
        };

        $values = ['key' => []];

        $result = $class::zeroOrInteger($values, 'key');

        self::assertSame(0, $result);
    }

    #[Test]
    public function zeroOrFloat(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::zeroOrFloat as public;
            }
        };

        $values = ['key' => '42.5'];

        $result = $class::zeroOrFloat($values, 'key');

        self::assertSame(42.5, $result);
    }

    #[Test]
    public function zeroOrFloatReturnsZeroWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::zeroOrFloat as public;
            }
        };

        $values = [];

        $result = $class::zeroOrFloat($values, 'non-existent-key');

        self::assertSame(0.0, $result);
    }

    #[Test]
    public function zeroOrFloatReturnsZeroWhenValueIsEmptyArray(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::zeroOrFloat as public;
            }
        };

        $values = ['key' => []];

        $result = $class::zeroOrFloat($values, 'key');

        self::assertSame(0.0, $result);
    }

    #[Test]
    public function nullOrOne(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrOne as public;
            }
        };

        $values = ['key' => [['id' => 1, 'filename' => 'test.jpg']]];

        $result = $class::nullOrOne($values, 'key', Asset::class);

        self::assertInstanceOf(Asset::class, $result);
    }

    #[Test]
    public function nullOrOneReturnsNullWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrOne as public;
            }
        };

        $values = [];

        $result = $class::nullOrOne($values, 'non-existent-key', Asset::class);

        self::assertNull($result);
    }

    #[Test]
    public function nullOrOneReturnsNullWhenArrayIsEmpty(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrOne as public;
            }
        };

        $values = ['key' => []];

        $result = $class::nullOrOne($values, 'key', Asset::class);

        self::assertNull($result);
    }

    #[Test]
    public function nullOrOneThrowsExceptionWhenArrayHasMoreThanOneItem(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrOne as public;
            }
        };

        $values = ['key' => [
            ['id' => 1, 'filename' => 'test1.jpg'],
            ['id' => 2, 'filename' => 'test2.jpg'],
        ]];

        $this->expectException(\InvalidArgumentException::class);

        $class::nullOrOne($values, 'key', Asset::class);
    }

    #[Test]
    public function boolean(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::boolean as public;
            }
        };

        $values = ['key' => true];

        $result = $class::boolean($values, 'key');

        self::assertTrue($result);
    }

    #[Test]
    public function booleanReturnsFalseWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::boolean as public;
            }
        };

        $values = [];

        $result = $class::boolean($values, 'non-existent-key');

        self::assertFalse($result);
    }

    #[Test]
    public function booleanReturnsFalseWhenValueIsNotTrue(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::boolean as public;
            }
        };

        $values = ['key' => 'not-true'];

        $result = $class::boolean($values, 'key');

        self::assertFalse($result);
    }

    #[Test]
    public function nullOrAsset(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrAsset as public;
            }
        };

        $values = ['key' => ['id' => 1, 'filename' => 'test.jpg']];

        $result = $class::nullOrAsset($values, 'key');

        self::assertInstanceOf(Asset::class, $result);
    }

    #[Test]
    public function nullOrAssetReturnsNullWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrAsset as public;
            }
        };

        $values = [];

        $result = $class::nullOrAsset($values, 'non-existent-key');

        self::assertNull($result);
    }

    #[Test]
    public function nullOrAssetReturnsNullWhenAssetConstructorThrowsException(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrAsset as public;
            }
        };

        $values = ['key' => ['invalid' => 'data']];

        $result = $class::nullOrAsset($values, 'key');

        self::assertNull($result);
    }

    #[Test]
    public function nullOrMultiLink(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrMultiLink as public;
            }
        };

        $values = ['key' => [
            'fieldtype' => 'multilink',
            'linktype' => 'url',
            'url' => 'https://example.com',
        ]];

        $result = $class::nullOrMultiLink($values, 'key');

        self::assertInstanceOf(MultiLink::class, $result);
    }

    #[Test]
    public function nullOrMultiLinkReturnsNullWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrMultiLink as public;
            }
        };

        $values = [];

        $result = $class::nullOrMultiLink($values, 'non-existent-key');

        self::assertNull($result);
    }

    #[Test]
    public function nullOrMultiLinkReturnsNullWhenUrlAndIdAreEmpty(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrMultiLink as public;
            }
        };

        $values = ['key' => [
            'url' => '',
            'id' => '',
        ]];

        $result = $class::nullOrMultiLink($values, 'key');

        self::assertNull($result);
    }

    #[Test]
    public function nullOrMultiLinkReturnsNullWhenUrlAndIdAreWhitespace(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrMultiLink as public;
            }
        };

        $values = ['key' => [
            'url' => '   ',
            'id' => '   ',
        ]];

        $result = $class::nullOrMultiLink($values, 'key');

        self::assertNull($result);
    }

    #[Test]
    public function nullOrMultiLinkReturnsNullWhenMultiLinkConstructorThrowsException(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrMultiLink as public;
            }
        };

        $values = ['key' => ['invalid' => 'data']];

        $result = $class::nullOrMultiLink($values, 'key');

        self::assertNull($result);
    }

    #[Test]
    public function nullOrString(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrString as public;
            }
        };

        $values = ['key' => '  hello world  '];

        $result = $class::nullOrString($values, 'key');

        self::assertSame('hello world', $result);
    }

    #[Test]
    public function nullOrStringReturnsNullWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrString as public;
            }
        };

        $values = [];

        $result = $class::nullOrString($values, 'non-existent-key');

        self::assertNull($result);
    }

    #[Test]
    public function nullOrStringReturnsNullWhenValueIsEmpty(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrString as public;
            }
        };

        $values = ['key' => ''];

        $result = $class::nullOrString($values, 'key');

        self::assertNull($result);
    }

    #[Test]
    public function string(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::string as public;
            }
        };

        $values = ['key' => '  hello world  '];

        $result = $class::string($values, 'key');

        self::assertSame('hello world', $result);
    }

    #[Test]
    public function stringWithMaxLength(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::string as public;
            }
        };

        $values = ['key' => 'hello'];

        $result = $class::string($values, 'key', 10);

        self::assertSame('hello', $result);
    }

    #[Test]
    public function stringThrowsExceptionWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::string as public;
            }
        };

        $values = [];

        $this->expectException(\InvalidArgumentException::class);

        $class::string($values, 'non-existent-key');
    }

    #[Test]
    public function stringThrowsExceptionWhenMaxLengthExceeded(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::string as public;
            }
        };

        $values = ['key' => 'hello world'];

        $this->expectException(\InvalidArgumentException::class);

        $class::string($values, 'key', 5);
    }

    #[Test]
    public function nullOrEditable(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrEditable as public;
            }
        };

        $values = ['key' => '<!--#storyblok#{"uid":"550e8400-e29b-41d4-a716-446655440000","id":"123","name":"test","space":"456"}-->'];

        $result = $class::nullOrEditable($values, 'key');

        self::assertInstanceOf(Editable::class, $result);
    }

    #[Test]
    public function nullOrEditableReturnsNullWhenKeyDoesNotExist(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrEditable as public;
            }
        };

        $values = [];

        $result = $class::nullOrEditable($values, 'non-existent-key');

        self::assertNull($result);
    }

    #[Test]
    public function nullOrEditableReturnsNullWhenEditableConstructorThrowsException(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrEditable as public;
            }
        };

        $values = ['key' => 'invalid-editable-string'];

        $result = $class::nullOrEditable($values, 'key');

        self::assertNull($result);
    }
    #[Test]
    public function nullOrStringReturnsNullWhenValueIsOnlyWhitespace(): void
    {
        $class = new class() {
            use ValueObjectTrait {
                ValueObjectTrait::nullOrString as public;
            }
        };

        $values = ['key' => '   '];

        $result = $class::nullOrString($values, 'key');

        self::assertNull($result);
    }
}
