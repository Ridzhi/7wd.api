<?php

namespace App\Tests\Domain\Game\Card;

use App\Domain\Game\Age;
use App\Domain\Game\Card\Repository;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Domain\Game\Card\Repository
 */
class RepositoryTest extends TestCase
{
    /**
     * @covers ::getByAge
     * @dataProvider ageCardsCounterProvider
     */
    public function testGetByAge(Age $age, int $count): void
    {
        $this->assertCount(
            $count,
            Repository::getByAge($age),
        );
    }

    /**
     * @covers ::getGuilds
     */
    public function testGetGuilds(): void
    {
        $this->assertCount(
            7,
            Repository::getGuilds(),
        );
    }

    protected function ageCardsCounterProvider(): array
    {
        return [
            'age I' => [
                Age::I,
                23,
            ],
            'age II' => [
                Age::II,
                23,
            ],
            'age III' => [
                Age::III,
                20,
            ],
        ];
    }
}
