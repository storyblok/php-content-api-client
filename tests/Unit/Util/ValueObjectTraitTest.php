<?php

declare(strict_types=1);

namespace Storyblok\Api\Tests\Unit\Util;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Tests\Util\FakerTrait;
use Storyblok\Api\Util\ValueObjectTrait;

final class ValueObjectTraitTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function one(): void
    {
        $class = new class {
            use ValueObjectTrait {
                ValueObjectTrait::one as public;
            }
        };

        $values = ['key' => ['value']];

        self::assertInstanceOf(
            \stdClass::class,
            $class::one($values, 'key', \stdClass::class),
        );
    }

    #[Test]
    public function oneThrowsInvalidArgumentException(): void
    {
        $class = new class {
            use ValueObjectTrait {
                ValueObjectTrait::one as public;
            }
        };

        $values = ['key' => ['value']];

        self::expectException(\InvalidArgumentException::class);

        $class::one($values, 'non-existent-key', \stdClass::class);
    }
}
