<?php

namespace App\Tests\Domain\Game\Wonder;

use App\Domain\Game\Wonder\Id;
use App\Domain\Game\Wonder\Repository;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Domain\Game\Wonder\Repository
 */
class RepositoryTest extends TestCase
{
    /**
     * @covers ::get
     */
    public function testGet(): void
    {
        $this->assertNotNull(Repository::get(Id::Messe));
    }

    /**
     * @covers ::getAll
     */
    public function testGetAll(): void
    {
        $this->assertCount(
            14,
            Repository::getAll(),
        );
    }
}
