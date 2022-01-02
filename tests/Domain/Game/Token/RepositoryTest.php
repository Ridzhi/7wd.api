<?php

namespace App\Tests\Domain\Game\Token;

use App\Domain\Game\Token\Id;
use App\Domain\Game\Token\Repository;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Domain\Game\Token\Repository
 */
class RepositoryTest extends TestCase
{
    /**
     * @covers ::get
     */
    public function testGet(): void
    {
        $this->assertNotNull(Repository::get(Id::Architecture));
    }

    /**
     * @covers ::getAll
     */
    public function testGetAll(): void
    {
        $this->assertCount(
            10,
            Repository::getAll(),
        );
    }
}
