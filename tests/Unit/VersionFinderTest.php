<?php

/*
 * This file is part of the PHPCR Migrations package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPCR\Migrations\tests\Unit;

use PHPCR\Migrations\VersionCollection;
use PHPCR\Migrations\VersionFinder;
use PHPUnit\Framework\TestCase;

class VersionFinderTest extends TestCase
{
    public function setUp()
    {
        $this->finder = new VersionFinder(array(
            __DIR__ . '/../migrations',
        ));
    }

    /**
     * It should return all version classes.
     *
     * @runInSeparateProcess
     */
    public function testGetCollection()
    {
        $collection = $this->finder->getCollection();
        $this->assertInstanceOf('PHPCR\Migrations\VersionCollection', $collection);
        $versions = $collection->getAllVersions();
        $this->assertCount(3, $versions);
    }

    /**
     * It should do nothing if no migrations paths are given.
     */
    public function testNoMigrationPaths()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No paths were provided');
        $versionFinder = new VersionFinder(array());
    }
}
