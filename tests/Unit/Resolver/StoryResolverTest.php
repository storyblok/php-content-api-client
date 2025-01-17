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

namespace Storyblok\Api\Tests\Unit\Resolver;

use PHPUnit\Framework\TestCase;
use Storyblok\Api\Resolver\StoryResolver;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class StoryResolverTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function resolve(): void
    {
        $resolver = new StoryResolver();

        $faker = self::faker();

        $story = [
            'name' => $faker->word(),
            'content' => [
                'uuid' => $faker->uuid(),
                'reference' => $referenceUuid = $faker->uuid(),
                'some_field' => $faker->word(),
            ],
        ];

        $references = [
            $reference = [
                'uuid' => $referenceUuid,
                'name' => $faker->word(),
                'another_field' => $faker->sentence(),
            ],
        ];

        $expected = $story;
        $expected['content']['reference'] = $reference;

        self::assertSame($expected, $resolver->resolve($story, $references));
    }

    /**
     * @test
     */
    public function resolveThrowsExceptionWhenUuidKeyDoesNotExist(): void
    {
        $resolver = new StoryResolver();

        $faker = self::faker();

        $reference = [
            'id' => $faker->uuid(),
            'name' => $faker->word(),
            'another_field' => $faker->sentence(),
        ];

        self::expectException(\InvalidArgumentException::class);

        $resolver->resolve(['name' => $faker->word()], [$reference]);
    }

    /**
     * @test
     */
    public function resolveThrowsExceptionWhenUuidKeyContainsNoValidUuid(): void
    {
        $resolver = new StoryResolver();

        $faker = self::faker();

        $reference = [
            'uuid' => $faker->word(),
            'name' => $faker->word(),
            'another_field' => $faker->sentence(),
        ];

        self::expectException(\InvalidArgumentException::class);

        $resolver->resolve(['name' => $faker->word()], [$reference]);
    }

    /**
     * @test
     */
    public function resolveWithComplexStructure(): void
    {
        $resolver = new StoryResolver();

        $faker = self::faker();

        $story = [
            'name' => $faker->word(),
            'content' => [
                'uuid' => $faker->uuid(),
                'references' => [
                    $referenceUuid1 = $faker->uuid(),
                    $referenceUuid2 = $faker->uuid(),
                    $referenceUuid3 = $faker->uuid(),
                    $referenceUuid4 = $faker->uuid(),
                ],
                'blocks' => [
                    [
                        'uuid' => $faker->uuid(),
                        'type' => 'card',
                        'block' => [
                            'uuid' => $faker->uuid(),
                            'type' => 'button',
                            'some_field' => $referenceUuid5 = $faker->uuid(),
                        ],
                    ],
                ],
                'some_field' => $faker->word(),
            ],
        ];

        $references = [
            [
                'uuid' => $referenceUuid1,
                'name' => $faker->word(),
                'another_field' => $faker->sentence(),
            ],
            [
                'uuid' => $referenceUuid2,
                'name' => $faker->word(),
                'another_field' => $faker->sentence(),
            ],
            [
                'uuid' => $referenceUuid3,
                'name' => $faker->word(),
                'another_field' => $faker->sentence(),
            ],
            [
                'uuid' => $referenceUuid4,
                'name' => $faker->word(),
                'another_field' => $faker->sentence(),
            ],
            [
                'uuid' => $referenceUuid5,
                'name' => $faker->word(),
                'price' => $faker->randomNumber(),
            ],
        ];

        $expected = $story;
        $expected['content']['references'] = [$references[0], $references[1], $references[2], $references[3]];
        $expected['content']['blocks'][0]['block']['some_field'] = $references[4];

        self::assertSame($expected, $resolver->resolve($story, $references));
    }
}
