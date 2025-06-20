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

namespace Storyblok\Api\Bridge\Faker;

use Faker\Factory;
use Faker\Generator as BaseGenerator;
use Storyblok\Api\Bridge\Faker\Provider\StoryblokProvider;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 *
 * @method array  assetFilename(?int $width = null, ?int $height = null, ?string $extension = null)
 * @method array  assetResponse(array $overrides = [])
 * @method array  datasourceDimensionResponse(array $overrides = [])
 * @method array  datasourceEntriesResponse(array $overrides = [])
 * @method array  datasourceEntryResponse(array $overrides = [])
 * @method array  datasourceResponse(array $overrides = [])
 * @method array  datasourcesResponse(array $overrides = [])
 * @method string editable(?string $uid = null, ?string $id = null, ?string $name = null, ?string $space = null)
 * @method array  linkAlternateResponse(array $overrides = [])
 * @method array  linkResponse(array $overrides = [])
 * @method array  linksResponse(array $overrides = [])
 * @method array  multiLinkResponse(array $overrides = [])
 * @method string relation()
 * @method array  richTextEmptyResponse()
 * @method array  richTextParagraphResponse(?string $text = null)
 * @method array  richTextResponse(array $overrides = [])
 * @method array  spaceResponse(array $overrides = [])
 * @method array  storiesResponse(array $overrides = [])
 * @method array  storyAssetResponse(array $overrides = [])
 * @method array  storyResponse(array $overrides = [])
 * @method array  tagsResponse(array $overrides = [])
 */
final class Generator extends BaseGenerator
{
    public function __construct()
    {
        parent::__construct();

        // Get a default generator with default providers
        $generator = Factory::create('de_DE');

        $generator->seed(9001);

        // Add custom providers
        $generator->addProvider(new StoryblokProvider($generator));

        // copy default and custom providers to this custom generator
        foreach ($generator->getProviders() as $provider) {
            $this->addProvider($provider);
        }
    }
}
