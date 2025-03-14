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

namespace Storyblok\Api\Tests\Unit\Response;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Response\DatasourceResponse;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class DatasourceResponseTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function datasource(): void
    {
        $faker = self::faker();
        $values = ['datasource' => $faker->datasourceResponse([
            'name' => $name = $faker->word(),
        ])];

        self::assertSame($name, (new DatasourceResponse($values))->datasource->name);
    }

    #[Test]
    public function datasourceKeyMustExist(): void
    {
        $values = self::faker()->datasourceResponse();

        self::expectException(\InvalidArgumentException::class);

        new DatasourceResponse($values);
    }
}
