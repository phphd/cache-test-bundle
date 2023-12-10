PhdCacheTestBundle
==================

🧰 Provides Symfony Cache clearing extension for PHPUnit.

[![Codecov](https://codecov.io/gh/phphd/cache-test-bundle/graph/badge.svg?token=4M4X4DFHG6)](https://codecov.io/gh/phphd/cache-test-bundle)
[![Licence](https://img.shields.io/github/license/phphd/cache-test-bundle.svg)](https://github.com/phphd/cache-test-bundle/blob/main/LICENSE)
[![Build Status](https://github.com/phphd/cache-test-bundle/actions/workflows/ci.yaml/badge.svg?branch=main)](https://github.com/phphd/cache-test-bundle/actions?query=branch%3Amain)

## Installation ⚒️

1. Install via composer

    ```sh
    composer require --dev phphd/cache-test-bundle
    ```

2. Enable the bundle in the `bundles.php`

    ```php
    PhPhD\CacheTestBundle\PhdCacheTestBundle::class => ['test' => true],
    ```

3. Add PHPUnit extension

    ```xml
        <extensions>
            <extension class="PhPhD\CacheTestBundle\PHPUnit\ClearCachePoolsExtension"/>
        </extensions>
    ```

## Usage 🚀

It is possible to use this bundle to clear cache pools for any tests that extend
`Symfony\Bundle\FrameworkBundle\Test\KernelTestCase` (`WebTestCase`, `ApiTestCase`, etc.)

Use `#[ClearPool]` attribute in order to clear caches:
```php
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PhPhD\CacheTestBundle\Attribute\ClearPool;

#[ClearPool('my_cache_pool')]
final class BlogControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/blog/');

        self::assertResponseIsSuccessful();
    }
}
```

In the example above, `my_cache_pool` will be cleared before every test from `BlogControllerTest`.
