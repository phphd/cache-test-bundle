<?php

declare(strict_types=1);

use PhPhD\CacheTest\Tests\Stub\Outlet\KernelTestCaseStub;
use PhPhD\CacheTest\Tests\Stub\Outlet\WebTestCaseStub;

\class_alias(KernelTestCaseStub::class, Symfony\Bundle\FrameworkBundle\Test\KernelTestCase::class);
\class_alias(WebTestCaseStub::class, Symfony\Bundle\FrameworkBundle\Test\WebTestCase::class);
