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

use PHPUnit\Framework\TestCase;
use Storyblok\Api\Response\AssetResponse;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class AssetResponseTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function assetKeyMustExist(): void
    {
        $values = self::faker()->assetResponse();
        unset($values['asset']);

        self::expectException(\InvalidArgumentException::class);

        new AssetResponse($values);
    }
}
