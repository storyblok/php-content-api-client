<div align="center">
    <img src="assets/php-content-delivery-api-client-github-repository.png" alt="Storyblok PHP Content API Client" align="center" />
    <h1 align="center">Storyblok Content Delivery API Client</h1>
    <p align="center">Co-created with <a href="https://sensiolabs.com/">SensioLabs</a>, the creators of Symfony.</p>
</div>

| Branch    | PHP                                         | Code Coverage                                                                                                                                  |
|-----------|---------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------|
| `master`  | [![PHP](https://github.com/storyblok/php-content-api-client/actions/workflows/ci.yaml/badge.svg)](https://github.com/storyblok/php-content-api-client/actions/workflows/ci.yaml)  | [![codecov](https://codecov.io/gh/storyblok/php-content-api-client/graph/badge.svg)](https://codecov.io/gh/storyblok/php-content-api-client) |

## Symfony

Use the [storyblok/storyblok-bundle](https://github.com/storyblok/storyblok-bundle) to integrate this library into your Symfony application.

## Usage

### Installation

```bash
composer require storyblok/php-content-api-client
```

### Setup

```php
use Storyblok\Api\StoryblokClient;

$client = new StoryblokClient(
    baseUri: 'https://api.storyblok.com',
    token: '***********',
    timeout: 10 // optional
);

// you can now request any endpoint which needs authentication
$client->request('GET', '/api/something', $options);
```

## Spaces

In your code you should type-hint to `Storyblok\Api\SpacesApiInterface`

### Get the current space

Returns the space associated with the current token.

```php
use Storyblok\Api\SpacesApi;
use Storyblok\Api\StoryblokClient;

$client = new StoryblokClient(/* ... */);
$spacesApi = new SpacesApi($client);

$response = $spacesApi->me();
```

## Stories

In your code you should type-hint to `Storyblok\Api\StoriesApiInterface`

### Get all available stories

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Request\StoriesRequest;

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client);
$response = $storiesApi->all(new StoriesRequest(language: 'de'));
```

### Fetch by Version (`draft`, `published`)

#### Global

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Domain\Value\Dto\Version;
use Storyblok\Api\Request\StoryRequest;

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client, Version::Draft);
$response = $storiesApi->bySlug('/my-story/', new StoryRequest(
    language: 'de',
));
```

#### Method Call

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Domain\Value\Dto\Version;
use Storyblok\Api\Request\StoryRequest;

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client, Version::Published);
$response = $storiesApi->bySlug('/my-story/', new StoryRequest(
    language: 'de',
    version: Version::Draft, // This overrides the global "version"
));
```

### Pagination

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Request\StoriesRequest;

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client);
$response = $storiesApi->all(new StoriesRequest(
    language: 'de',
    pagination: new Pagination(page: 1, perPage: 30)
));
```

#### Sorting

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Domain\Value\Dto\SortBy;
use Storyblok\Api\Domain\Value\Dto\Direction;
use Storyblok\Api\Request\StoriesRequest;

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client);
$response = $storiesApi->all(new StoriesRequest(
    language: 'de',
    sortBy: new SortBy(field: 'title', direction: Direction::Desc)
));
```

#### Filtering

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Domain\Value\Filter\FilterCollection;
use Storyblok\Api\Domain\Value\Dto\Direction;
use Storyblok\Api\Domain\Value\Filter\Filters\InFilter;
use Storyblok\Api\Request\StoriesRequest;

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client);
$response = $storiesApi->all(new StoriesRequest(
    language: 'de',
    filters: new FilterCollection([
        new InFilter(field: 'single_reference_field', value: 'f2fdb571-a265-4d8a-b7c5-7050d23c2383')
    ])
));
```

#### Available filters

[AllInArrayFilter.php](src/Domain/Value/Filter/Filters/AllInArrayFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\AllInArrayFilter;

new AllInArrayFilter(field: 'tags', value: ['foo', 'bar', 'baz']);
```

[AnyInArrayFilter.php](src/Domain/Value/Filter/Filters/AnyInArrayFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\AnyInArrayFilter;

new AnyInArrayFilter(field: 'tags', value: ['foo', 'bar', 'baz']);
```

[GreaterThanDateFilter.php](src/Domain/Value/Filter/Filters/GreaterThanDateFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\GreaterThanDateFilter;

new GreaterThanDateFilter(field: 'created_at', value: new \DateTimeImmutable());
```

[LessThanDateFilter.php](src/Domain/Value/Filter/Filters/LessThanDateFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\LessThanDateFilter;

new LessThanDateFilter(field: 'created_at', value: new \DateTimeImmutable());
```

[GreaterThanFloatFilter.php](src/Domain/Value/Filter/Filters/GreaterThanFloatFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\GreaterThanFloatFilter;

new GreaterThanFloatFilter(field: 'price', value: 39.99);
```

[LessThanFloatFilter.php](src/Domain/Value/Filter/Filters/LessThanFloatFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\LessThanFloatFilter;

new LessThanFloatFilter(field: 'price', value: 199.99);
```

[GreaterThanIntFilter.php](src/Domain/Value/Filter/Filters/GreaterThanIntFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\GreaterThanIntFilter;

new GreaterThanIntFilter(field: 'stock', value: 0);
```

[LessThanIntFilter.php](src/Domain/Value/Filter/Filters/LessThanIntFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\LessThanIntFilter;

new LessThanIntFilter(field: 'stock', value: 100);
```

[InFilter.php](src/Domain/Value/Filter/Filters/InFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\InFilter;

new InFilter(field: 'text', value: 'Hello World!');
// or
new InFilter(field: 'text', value: ['Hello Symfony!', 'Hello SensioLabs!']);
```

[NotInFilter.php](src/Domain/Value/Filter/Filters/NotInFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\NotInFilter;

new NotInFilter(field: 'text', value: 'Hello World!');
// or
new NotInFilter(field: 'text', value: ['Bye Symfony!', 'Bye SensioLabs!']);
```

[IsFilter.php](src/Domain/Value/Filter/Filters/IsFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\IsFilter;

// You can use one of the following constants:
// IsFilter::EMPTY_ARRAY
// IsFilter::NOT_EMPTY_ARRAY
// IsFilter::EMPTY
// IsFilter::NOT_EMPTY
// IsFilter::TRUE
// IsFilter::FALSE
// IsFilter::NULL
// IsFilter::NOT_NULL

new IsFilter(field: 'text', value: IsFilter::EMPTY);
```

[LikeFilter.php](src/Domain/Value/Filter/Filters/LikeFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\LikeFilter;

new LikeFilter(field: 'description', value: '*I love Symfony*');
```

[NotLikeFilter.php](src/Domain/Value/Filter/Filters/NotLikeFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\NotLikeFilter;

new NotLikeFilter(field: 'description', value: '*Text*');
```

[OrFilter.php](src/Domain/Value/Filter/Filters/OrFilter.php)

Example:
```php
use Storyblok\Api\Domain\Value\Filter\Filters\OrFilter;
use Storyblok\Api\Domain\Value\Filter\Filters\LikeFilter;
use Storyblok\Api\Domain\Value\Filter\Filters\NotLikeFilter;

new OrFilter(
    new LikeFilter(field: 'text', value: 'Yes!*'),
    new LikeFilter(field: 'text', value: 'Maybe!*'),
    // ...
);
```

### Get all available stories by Content Type (`string`)

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Request\StoriesRequest;

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client);
$response = $storiesApi->allByContentType('custom_content_type', new StoriesRequest(
    language: 'de',
));
```

### Get multiple stories by multiple uuid's (`array`)

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Request\StoriesRequest;
use Storyblok\Api\Domain\Value\Uuid;

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client);
$response = $storiesApi->allByUuids([new Uuid(/** ... */), new Uuid(/** ... */)], new StoriesRequest(
    language: 'de',
));
```

### Get by uuid (`Storyblok\Api\Domain\Value\Uuid`)

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Domain\Value\Uuid;
use Storyblok\Api\Request\StoryRequest;

$uuid = new Uuid(/** ... */);

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client);
$response = $storiesApi->byUuid($uuid, new StoryRequest(
    language: 'de',
));
```

### Get by slug (`string`)

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Request\StoryRequest;

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client);
$response = $storiesApi->bySlug('folder/slug', new StoryRequest(
    language: 'de',
));
```


### Get by id (`Storyblok\Api\Domain\Value\Id`)

```php
use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Domain\Value\Id;
use Storyblok\Api\Request\StoryRequest;

$id = new Id(/** ... */);

$client = new StoryblokClient(/* ... */);

$storiesApi = new StoriesApi($client);
$response = $storiesApi->byId($id, new StoryRequest(
    language: 'de',
));
```


## Links

In your code you should type-hint to `Storyblok\Api\LinksApiInterface`

### Get all available links

```php
use Storyblok\Api\LinksApi;
use Storyblok\Api\StoryblokClient;

$client = new StoryblokClient(/* ... */);

$linksApi = new LinksApi($client);
$response = $linksApi->all();
```

### Pagination

```php
use Storyblok\Api\LinksApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Request\LinksRequest;

$client = new StoryblokClient(/* ... */);

$linksApi = new LinksApi($client);
$response = $linksApi->all(new LinksRequest(
    pagination: new Pagination(page: 1, perPage: 1000)
));
```

### Get by parent (`Storyblok\Api\Domain\Value\Id`)

```php
use Storyblok\Api\LinksApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Domain\Value\Id;

$id = new Id(/** ... */);

$client = new StoryblokClient(/* ... */);

$linksApi = new LinksApi($client);
$response = $linksApi->byParent($id);
```

### Get all root links

```php
use Storyblok\Api\LinksApi;
use Storyblok\Api\StoryblokClient;

$client = new StoryblokClient(/* ... */);

$linksApi = new LinksApi($client);
$response = $linksApi->roots($id);
```


## Datasource

In your code you should type-hint to `Storyblok\Api\DatasourceApiInterface`

### Get by name (`string`)

```php
use Storyblok\Api\DatasourceApi;
use Storyblok\Api\StoryblokClient;

$client = new StoryblokClient(/* ... */);

$api = new DatasourceApi($client);
$response = $api->byName('tags'); // returns Storyblok\Api\Domain\Value\Datasource
```

If it has more than one dimension, you can get the entries by

```php
use Storyblok\Api\DatasourceApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\Domain\Value\Datasource\Dimension;

$client = new StoryblokClient(/* ... */);

$api = new DatasourceApi($client);
$response = $api->byName('tags', new Dimension('de')); // returns Storyblok\Api\Domain\Value\Datasource
```

## Tags

In your code you should type-hint to `Storyblok\Api\TagsApiInterface`

### Get all available tags

```php
use Storyblok\Api\TagsApi;
use Storyblok\Api\StoryblokClient;

$client = new StoryblokClient(/* ... */);

$api = new TagsApi($client);
$response = $api->all(); // returns Storyblok\Api\Response\TagsResponse
```


## Assets

To use the assets API you have to configure the Assets client.

```php
use Storyblok\Api\StoryblokClient;
use Storyblok\Api\AssetsApi;

$client = new StoryblokClient(
    baseUri: 'https://api.storyblok.com',
    token: 'assets-api-token',
    timeout: 10 // optional
);

$assetsApi = new AssetsApi($assetsClient);
$assetsApi->get('filename.png')
```

### DX Enhancement through Abstract Collections

To improve developer experience (DX), especially when working with content types like stories, the following abstract
class is provided to manage collections of specific content types. This class simplifies data handling and ensures type
safety while dealing with large amounts of content from Storyblok.

#### Abstract ContentTypeCollection Class

The ContentTypeCollection class provides a structured way to work with Storyblok content types. It makes managing
pagination, filtering, and sorting more intuitive and reusable, saving time and reducing boilerplate code.

```php
<?php

declare(strict_types=1);

namespace App\ContentType;

use IteratorAggregate;
use Storyblok\Api\Response\StoriesResponse;

/**
 * @template T of ContentTypeInterface
 *
 * @implements IteratorAggregate<int, T>
 */
abstract readonly class ContentTypeCollection implements \Countable, \IteratorAggregate
{
    public int $total;
    public int $perPage;
    public int $curPage;
    public int $lastPage;
    public ?int $prevPage;
    public ?int $nextPage;

    /**
     * @var list<T>
     */
    private array $items;

    final public function __construct(StoriesResponse $response)
    {
        $this->items = array_values(array_map($this->createItem(...), $response->stories));

        $this->total = $response->total->value;
        $this->curPage = $response->pagination->page;
        $this->perPage = $response->pagination->perPage;

        $this->lastPage = (int) ceil($this->total / $this->perPage);
        $this->prevPage = 1 < $this->curPage ? $this->curPage - 1 : null;
        $this->nextPage = $this->curPage < $this->lastPage ? $this->curPage + 1 : null;
    }

    /**
     * @return \Traversable<int, T>
     */
    final public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    final public function count(): int
    {
        return \count($this->items);
    }

    /**
     * @param array<string, mixed> $values
     *
     * @return T
     */
    abstract protected function createItem(array $values): ContentTypeInterface;
}
```

#### Benefits of Using the Abstract Collection:

1. **Simplified Data Handling:** Instead of dealing with raw arrays of stories, this abstract class helps you manage
   collections of content types, like blog posts or articles, in an organized manner. It abstracts away the repetitive
   work of pagination and mapping response data to objects.
2. **Enhanced Readability:** Using a well-structured collection class makes the code easier to read and maintain. Instead of
   handling pagination and raw data structures in controllers or services, you simply instantiate the collection and let
   it handle the data.
3. **Reusability:** The class is flexible and reusable across different content types. Once implemented, you can easily
   create new collections for other Storyblok content types with minimal extra code.
4. **Pagination and Metadata Management:** The collection class comes with built-in properties for pagination and
   metadata (e.g., total items, current page, etc.), making it much easier to manage paginated data efficiently.

### Example Usage with a Collection

Here is an example of how to use the ContentTypeCollection to manage blog posts in your Symfony project:

```php
<?php

declare(strict_types=1);

namespace App\ContentType\BlogPost;

use App\ContentType\ContentTypeCollection;
use App\ContentType\ContentTypeFactory;

/**
 * @extends ContentTypeCollection<BlogPost>
 */
final readonly class BlogPostCollection extends ContentTypeCollection
{
    protected function createItem(array $values): BlogPost
    {
        return ContentTypeFactory::create($values, BlogPost::class);
    }
}
```

```php
new BlogPostCollection(
    $this->stories->allByContentType(
        BlogPost::type(),
        new StoriesRequest(
            language: $this->localeSwitcher->getLocale(),
            pagination: new Pagination($this->curPage, self::PER_PAGE),
            sortBy: new SortBy('first_published_at', Direction::Desc),
            filters: $filters,
            excludeFields: new FieldCollection([
                new Field('body'),
                new Field('additional_contents'),
            ]),
        ),
    ),
);
```

### Helpers

The `Storyblok\Api\Util\ValueObjectTrait` provides utility methods for mapping raw Storyblok data arrays into strong PHP
value objects, enums, and domain models. These helpers reduce boilerplate code and improve readability in DTO
constructors or factory methods.

Use this trait in your value objects or models to simplify the parsing and validation of Storyblok field values.

#### Available Methods

| Method                | Description                                                                                                      |
|-----------------------|------------------------------------------------------------------------------------------------------------------|
| `one()`               | Expects exactly one item (e.g. from a `blocks` field). Instantiates one object from it.                          |
| `list()`              | Maps a list of items to objects. Allows setting `$min`, `$max`, or exact `$count` constraints.                   |
| `nullOrOne()`         | Same as `one()`, but allows the field to be optional (returns `null` if empty).                                  |
| `enum()`              | Maps a string value to a backed enum. Supports default value and whitelisting of allowed values.                 |
| `DateTimeImmutable()` | Returns a `Safe\DateTimeImmutable` object from a given date string.                                              |
| `Uuid()`              | Returns a `Storyblok\Api\Domain\Value\Uuid` instance from a string.                                              |
| `Asset()`             | Maps an asset array to a `Storyblok\Api\Domain\Type\Asset` object.                                               |
| `nullOrAsset()`       | Same as `Asset()`, but allows null or invalid input.                                                             |
| `MultiLink()`         | Maps a multilink array to a `Storyblok\Api\Domain\Type\MultiLink` object.                                        |
| `nullOrMultiLink()`   | Same as `MultiLink()`, but returns `null` if `url` and `id` are missing or empty.                                |
| `RichText()`          | Maps rich text content to a `Storyblok\Api\Domain\Type\RichText` object.                                         |
| `nullOrRichText()`    | Same as `RichText()`, but returns `null` if content is empty or only contains whitespace.                        |
| `boolean()`           | Returns `true` if the key exists and its value is `true`, otherwise `false`.                                     |
| `zeroOrInteger()`     | Returns an integer from the field, or `0` if missing.                                                            |
| `zeroOrFloat()`       | Returns a float from the field, or `0.0` if missing.                                                             |
| `string()`            | Returns a trimmed non-empty string (using `TrimmedNonEmptyString`). Optional max length check.                   |
| `nullOrString()`      | Same as `string()`, but returns `null` if missing or invalid.                                                    |
| `nullOrEditable()`    | Returns an `Editable` instance or `null`.                                                                        |

[actions]: https://github.com/sensiolabs-de/storyblok-api/actions
[codecov]: https://codecov.io/gh/sensiolabs-de/storyblok-api

## Management API client

For the Management API PHP Client, see [storyblok/php-management-api-client](https://github.com/storyblok/php-management-api-client).

## License

This project is licensed under the MIT License. Please see [License File](LICENSE) for more information.
