<?php

declare(strict_types=1);

namespace PhPhD\CacheTestBundle\Tests;

use PhPhD\CacheTestBundle\PHPUnit\ClearCachePoolsExtension;
use PhPhD\CacheTestBundle\Tests\Stub\ClearableKernelTestCaseStub;
use PhPhD\CacheTestBundle\Tests\Stub\ClearableWebTestCaseStub;
use PhPhD\CacheTestBundle\Tests\Stub\NonClearableTestCaseStub;
use PhPhD\CacheTestBundle\Tests\Stub\Outlet\KernelTestCaseStub;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use stdClass;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UnexpectedValueException;

use function implode;

/**
 * @covers \PhPhD\CacheTestBundle\PHPUnit\ClearCachePoolsExtension
 * @covers \PhPhD\CacheTestBundle\Clearer\CacheItemPoolsClearer
 * @covers \PhPhD\CacheTestBundle\Clearer\TestClearer
 * @covers \PhPhD\CacheTestBundle\Accessor\TestContainerAccessor
 * @covers \PhPhD\CacheTestBundle\Attribute\ClearPool
 *
 * @internal
 */
final class ClearCachePoolsExtensionTest extends TestCase
{
    private ClearCachePoolsExtension $extension;

    private MockObject $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extension = new ClearCachePoolsExtension();

        $this->container = $this->createMock(ContainerInterface::class);

        KernelTestCaseStub::setContainer($this->container);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        KernelTestCaseStub::setContainer(null);
    }

    public function testDoesNotClearCacheForNonKernelTestCase(): void
    {
        $this->expectNotToPerformAssertions();

        $this->extension->executeBeforeTest(implode('::', [NonClearableTestCaseStub::class, 'testTrue']));
    }

    public function testClearsCacheForKernelTestCases(): void
    {
        $firstPool = $this->getPool();

        $secondPool = $this->getPool();

        $this->container
            ->method('get')
            ->willReturnMap([
                ['first', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, $firstPool],
                ['second', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, $secondPool],
            ]);

        $this->extension->executeBeforeTest(implode('::', [ClearableKernelTestCaseStub::class, 'testTrue']));
    }

    public function testThrowsExceptionWhenServiceIsNotCachePool(): void
    {
        $cachePool = new stdClass();

        $this->container
            ->method('get')
            ->willReturnMap([['web', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, $cachePool]]);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Expected the service "web" to be instance of Psr\Cache\CacheItemPoolInterface');

        $this->extension->executeBeforeTest(implode('::', [ClearableWebTestCaseStub::class, 'testTrue']));
        self::assertFalse(KernelTestCaseStub::isKernelBooted());
    }

    public function testClearsWebTestCase(): void
    {
        $cachePool = $this->getPool();

        $this->container
            ->method('get')
            ->willReturnMap([['web', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, $cachePool]]);

        $this->extension->executeBeforeTest(implode('::', [ClearableWebTestCaseStub::class, 'testTrue']));
        self::assertFalse(KernelTestCaseStub::isKernelBooted());
    }

    /** @return MockObject&CacheItemPoolInterface */
    private function getPool(): MockObject
    {
        $pool = $this->createMock(CacheItemPoolInterface::class);
        $pool->expects(self::once())->method('clear')->willReturn(true);

        return $pool;
    }
}
