<?php /** @noinspection PhpNamedArgumentsWithChangedOrderInspection */

namespace App\Domain\Game\Card;

use App\Domain\Game\Age;
use App\Domain\Game\Bonus;
use App\Domain\Game\Cost;
use App\Domain\Game\Discount\Context;
use App\Domain\Game\Discount\Discount;
use App\Domain\Game\Effect\AdjustDiscardReward;
use App\Domain\Game\Effect\Chain;
use App\Domain\Game\Effect\Coins;
use App\Domain\Game\Effect\CoinsFor;
use App\Domain\Game\Effect\Discounter;
use App\Domain\Game\Effect\FixedCost;
use App\Domain\Game\Effect\Guild;
use App\Domain\Game\Effect\Military;
use App\Domain\Game\Effect\Points;
use App\Domain\Game\Effect\Resource;
use App\Domain\Game\Effect\Science;
use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Symbol;

class Repository
{
    /**
     * @var array<int, Card>
     */
    private static ?array $data = null;

    /**
     * @var ?array{1: array<int>, 2: array<int>, 3: array<int>, guilds: array<int>}
     */
    private static ?array $cache = null;

    public static function get(Id $card): Card
    {
        return static::getData()[$card->value];
    }

    /**
     * @return array<Id>
     */
    public static function getByAge(Age $age): array
    {
        return self::getCache()[$age->value];
    }

    /**
     * @return array<Id>
     */
    public static function getGuilds(): array
    {
        return self::getCache()['guilds'];
    }

    /**
     * @return array{1: array<int>, 2: array<int>, 3: array<int>, guilds: array<int>}
     */
    private static function getCache(): array
    {
        if (!self::$cache) {
            self::$cache = [
                Age::I->value => [],
                Age::II->value => [],
                Age::III->value => [],
                'guilds' => [],
            ];

            foreach (self::getData() as $card) {
                if ($card->type === Type::Guild) {
                    self::$cache['guilds'][] = $card->id;
                    continue;
                }

                self::$cache[$card->age->value][] = $card->id;
            }
        }

        return self::$cache;
    }

    /**
     * @return array<int, Card>
     */
    private static function getData(): array
    {
        if (!self::$data) {
            self::$data = [
                Id::LumberYard->value => new Card(
                    id: Id::LumberYard,
                    age: Age::I,
                    type: Type::RawMaterials,
                    effects: [
                        new Resource(Rid::Wood, 1)
                    ],
                ),
                Id::LoggingCamp->value => new Card(
                    id: Id::LoggingCamp,
                    age: Age::I,
                    type: Type::RawMaterials,
                    cost: new Cost(coins: 1),
                    effects: [
                        new Resource(Rid::Wood, 1)
                    ],
                ),
                Id::ClayPool->value => new Card(
                    id: Id::ClayPool,
                    age: Age::I,
                    type: Type::RawMaterials,
                    effects: [
                        new Resource(Rid::Clay, 1)
                    ],
                ),
                Id::ClayPit->value => new Card(
                    id: Id::ClayPit,
                    age: Age::I,
                    type: Type::RawMaterials,
                    cost: new Cost(coins: 1),
                    effects: [
                        new Resource(Rid::Clay, 1)
                    ],
                ),
                Id::Quarry->value => new Card(
                    id: Id::Quarry,
                    age: Age::I,
                    type: Type::RawMaterials,
                    effects: [
                        new Resource(Rid::Stone, 1)
                    ],
                ),
                Id::StonePit->value => new Card(
                    id: Id::StonePit,
                    age: Age::I,
                    type: Type::RawMaterials,
                    cost: new Cost(coins: 1),
                    effects: [
                        new Resource(Rid::Stone, 1)
                    ],
                ),
                Id::GlassWorks->value => new Card(
                    id: Id::GlassWorks,
                    age: Age::I,
                    type: Type::ManufacturedGoods,
                    cost: new Cost(coins: 1),
                    effects: [
                        new Resource(Rid::Glass, 1)
                    ],
                ),
                Id::Press->value => new Card(
                    id: Id::Press,
                    age: Age::I,
                    type: Type::ManufacturedGoods,
                    cost: new Cost(coins: 1),
                    effects: [
                        new Resource(Rid::Papyrus, 1)
                    ],
                ),
                Id::GuardTower->value => new Card(
                    id: Id::GuardTower,
                    age: Age::I,
                    type: Type::Military,
                    effects: [
                        new Military(1),
                    ],
                ),
                Id::Workshop->value => new Card(
                    id: Id::Workshop,
                    age: Age::I,
                    type: Type::Science,
                    cost: new Cost(papyrus: 1),
                    effects: [
                        new Points(1),
                        new Science(Symbol::Compass),
                    ],
                ),
                Id::Apothecary->value => new Card(
                    id: Id::Apothecary,
                    age: Age::I,
                    type: Type::Science,
                    cost: new Cost(glass: 1),
                    effects: [
                        new Points(1),
                        new Science(Symbol::Wheel),
                    ],
                ),
                Id::StoneReserve->value => new Card(
                    id: Id::StoneReserve,
                    age: Age::I,
                    type: Type::Commercial,
                    cost: new Cost(coins: 3),
                    effects: [
                        new FixedCost(Rid::Stone),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::ClayReserve->value => new Card(
                    id: Id::ClayReserve,
                    age: Age::I,
                    type: Type::Commercial,
                    cost: new Cost(coins: 3),
                    effects: [
                        new FixedCost(Rid::Clay),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::WoodReserve->value => new Card(
                    id: Id::WoodReserve,
                    age: Age::I,
                    type: Type::Commercial,
                    cost: new Cost(coins: 3),
                    effects: [
                        new FixedCost(Rid::Wood),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::Stable->value => new Card(
                    id: Id::Stable,
                    age: Age::I,
                    type: Type::Military,
                    cost: new Cost(wood: 1),
                    effects: [
                        new Military(1),
                        new Chain(Id::HorseBreeders),
                    ],
                ),
                Id::Garrison->value => new Card(
                    id: Id::Garrison,
                    age: Age::I,
                    type: Type::Military,
                    cost: new Cost(clay: 1),
                    effects: [
                        new Military(1),
                        new Chain(Id::Barracks),
                    ],
                ),
                Id::Palisade->value => new Card(
                    id: Id::Palisade,
                    age: Age::I,
                    type: Type::Military,
                    cost: new Cost(coins: 2),
                    effects: [
                        new Military(1),
                        new Chain(Id::Fortifications),
                    ],
                ),
                Id::Scriptorium->value => new Card(
                    id: Id::Scriptorium,
                    age: Age::I,
                    type: Type::Science,
                    cost: new Cost(coins: 2),
                    effects: [
                        new Science(Symbol::Writing),
                        new Chain(Id::Library),
                    ],
                ),
                Id::Pharmacist->value => new Card(
                    id: Id::Pharmacist,
                    age: Age::I,
                    type: Type::Science,
                    cost: new Cost(coins: 2),
                    effects: [
                        new Science(Symbol::Mortar),
                        new Chain(Id::Dispensary),
                    ],
                ),
                Id::Theater->value => new Card(
                    id: Id::Theater,
                    age: Age::I,
                    type: Type::Civilian,
                    effects: [
                        new Points(3),
                        new Chain(Id::Statue),
                    ],
                ),
                Id::Altar->value => new Card(
                    id: Id::Altar,
                    age: Age::I,
                    type: Type::Civilian,
                    effects: [
                        new Points(3),
                        new Chain(Id::Temple),
                    ],
                ),
                Id::Baths->value => new Card(
                    id: Id::Baths,
                    age: Age::I,
                    type: Type::Civilian,
                    cost: new Cost(stone: 1),
                    effects: [
                        new Points(3),
                        new Chain(Id::Aqueduct),
                    ],
                ),
                Id::Tavern->value => new Card(
                    id: Id::Tavern,
                    age: Age::I,
                    type: Type::Commercial,
                    effects: [
                        new Coins(4),
                        new Chain(Id::Lighthouse),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::SawMill->value => new Card(
                    id: Id::SawMill,
                    age: Age::II,
                    type: Type::RawMaterials,
                    cost: new Cost(coins: 2),
                    effects: [
                        new Resource(Rid::Wood, 2),
                    ],
                ),
                Id::BrickYard->value => new Card(
                    id: Id::BrickYard,
                    age: Age::II,
                    type: Type::RawMaterials,
                    cost: new Cost(coins: 2),
                    effects: [
                        new Resource(Rid::Clay, 2),
                    ],
                ),
                Id::ShelfQuarry->value => new Card(
                    id: Id::ShelfQuarry,
                    age: Age::II,
                    type: Type::RawMaterials,
                    cost: new Cost(coins: 2),
                    effects: [
                        new Resource(Rid::Stone, 2),
                    ],
                ),
                Id::GlassBlower->value => new Card(
                    id: Id::GlassBlower,
                    age: Age::II,
                    type: Type::ManufacturedGoods,
                    effects: [
                        new Resource(Rid::Glass, 1),
                    ],
                ),
                Id::DryingRoom->value => new Card(
                    id: Id::DryingRoom,
                    age: Age::II,
                    type: Type::ManufacturedGoods,
                    effects: [
                        new Resource(Rid::Papyrus, 1),
                    ],
                ),
                Id::Walls->value => new Card(
                    id: Id::Walls,
                    age: Age::II,
                    type: Type::Military,
                    cost: new Cost(stone: 2),
                    effects: [
                        new Military(2),
                    ],
                ),
                Id::Forum->value => new Card(
                    id: Id::Forum,
                    age: Age::II,
                    type: Type::Commercial,
                    cost: new Cost(
                        coins: 3,
                        clay: 1,
                    ),
                    effects: [
                        new Discounter(new Discount(
                            Context::Global,
                            1,
                            Rid::Glass,
                            Rid::Papyrus,
                        )),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::Caravansery->value => new Card(
                    id: Id::Caravansery,
                    age: Age::II,
                    type: Type::Commercial,
                    cost: new Cost(
                        coins: 2,
                        glass: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Discounter(new Discount(
                            Context::Global,
                            1,
                            Rid::Wood,
                            Rid::Clay,
                            Rid::Stone,
                        )),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::CustomHouse->value => new Card(
                    id: Id::CustomHouse,
                    age: Age::II,
                    type: Type::Commercial,
                    cost: new Cost(coins: 4),
                    effects: [
                        new FixedCost(Rid::Papyrus, Rid::Glass),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::CourtHouse->value => new Card(
                    id: Id::CourtHouse,
                    age: Age::II,
                    type: Type::Civilian,
                    cost: new Cost(
                        wood: 2,
                        glass: 1,
                    ),
                    effects: [
                        new Points(5),
                    ],
                ),
                Id::HorseBreeders->value => new Card(
                    id: Id::HorseBreeders,
                    age: Age::II,
                    type: Type::Military,
                    cost: new Cost(
                        clay: 1,
                        wood: 1,
                    ),
                    effects: [
                        new Military(1),
                    ],
                ),
                Id::Barracks->value => new Card(
                    id: Id::Barracks,
                    age: Age::II,
                    type: Type::Military,
                    cost: new Cost(coins: 3),
                    effects: [
                        new Military(1),
                    ],
                ),
                Id::ArcheryRange->value => new Card(
                    id: Id::ArcheryRange,
                    age: Age::II,
                    type: Type::Military,
                    cost: new Cost(
                        stone: 1,
                        wood: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Military(2),
                        new Chain(Id::SiegeWorkshop),
                    ],
                ),
                Id::ParadeGround->value => new Card(
                    id: Id::ParadeGround,
                    age: Age::II,
                    type: Type::Military,
                    cost: new Cost(
                        clay: 2,
                        glass: 1,
                    ),
                    effects: [
                        new Military(2),
                        new Chain(Id::Circus),
                    ],
                ),
                Id::Library->value => new Card(
                    id: Id::Library,
                    age: Age::II,
                    type: Type::Science,
                    cost: new Cost(
                        stone: 1,
                        wood: 1,
                        glass: 1,
                    ),
                    effects: [
                        new Points(2),
                        new Science(Symbol::Writing),
                    ],
                ),
                Id::Dispensary->value => new Card(
                    id: Id::Dispensary,
                    age: Age::II,
                    type: Type::Science,
                    cost: new Cost(
                        clay: 2,
                        stone: 1,
                    ),
                    effects: [
                        new Points(2),
                        new Science(Symbol::Mortar),
                    ],
                ),
                Id::School->value => new Card(
                    id: Id::School,
                    age: Age::II,
                    type: Type::Science,
                    cost: new Cost(
                        wood: 1,
                        papyrus: 2,
                    ),
                    effects: [
                        new Points(1),
                        new Science(Symbol::Wheel),
                        new Chain(Id::University),
                    ],
                ),
                Id::Laboratory->value => new Card(
                    id: Id::Laboratory,
                    age: Age::II,
                    type: Type::Science,
                    cost: new Cost(
                        wood: 1,
                        glass: 2,
                    ),
                    effects: [
                        new Points(1),
                        new Science(Symbol::Compass),
                        new Chain(Id::Observatory),
                    ],
                ),
                Id::Statue->value => new Card(
                    id: Id::Statue,
                    age: Age::II,
                    type: Type::Civilian,
                    cost: new Cost(clay: 2),
                    effects: [
                        new Points(4),
                        new Chain(Id::Gardens),
                    ],
                ),
                Id::Temple->value => new Card(
                    id: Id::Temple,
                    age: Age::II,
                    type: Type::Civilian,
                    cost: new Cost(
                        wood: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Points(4),
                        new Chain(Id::Pantheon),
                    ],
                ),
                Id::Aqueduct->value => new Card(
                    id: Id::Aqueduct,
                    age: Age::II,
                    type: Type::Civilian,
                    cost: new Cost(stone: 3),
                    effects: [
                        new Points(5),
                    ],
                ),
                Id::Rostrum->value => new Card(
                    id: Id::Rostrum,
                    age: Age::II,
                    type: Type::Civilian,
                    cost: new Cost(
                        stone: 1,
                        wood: 1,
                    ),
                    effects: [
                        new Points(5),
                        new Chain(Id::Senate),
                    ],
                ),
                Id::Brewery->value => new Card(
                    id: Id::Brewery,
                    age: Age::II,
                    type: Type::Commercial,
                    effects: [
                        new Coins(6),
                        new Chain(Id::Arena),
                        new AdjustDiscardReward(),
                    ],
                ),

                Id::Arsenal->value => new Card(
                    id: Id::Arsenal,
                    age: Age::III,
                    type: Type::Military,
                    cost: new Cost(
                        clay: 3,
                        wood: 2,
                    ),
                    effects: [
                        new Military(3),
                    ],
                ),
                Id::Pretorium->value => new Card(
                    id: Id::Pretorium,
                    age: Age::III,
                    type: Type::Military,
                    cost: new Cost(coins: 8),
                    effects: [
                        new Military(3),
                    ],
                ),
                Id::Academy->value => new Card(
                    id: Id::Academy,
                    age: Age::III,
                    type: Type::Science,
                    cost: new Cost(
                        stone: 1,
                        wood: 1,
                        glass: 2,
                    ),
                    effects: [
                        new Points(3),
                        new Science(Symbol::Sundial),
                    ],
                ),
                Id::Study->value => new Card(
                    id: Id::Study,
                    age: Age::III,
                    type: Type::Science,
                    cost: new Cost(
                        wood: 2,
                        glass: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Points(3),
                        new Science(Symbol::Sundial),

                    ],
                ),
                Id::ChamberOfCommerce->value => new Card(
                    id: Id::ChamberOfCommerce,
                    age: Age::III,
                    type: Type::Commercial,
                    cost: new Cost(papyrus: 2),
                    effects: [
                        new Points(3),
                        new CoinsFor(Bonus::ManufacturedGoods, 3),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::Port->value => new Card(
                    id: Id::Port,
                    age: Age::III,
                    type: Type::Commercial,
                    cost: new Cost(
                        wood: 1,
                        glass: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Points(3),
                        new CoinsFor(Bonus::RawMaterials, 2),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::Armory->value => new Card(
                    id: Id::Armory,
                    age: Age::III,
                    type: Type::Commercial,
                    cost: new Cost(
                        stone: 2,
                        glass: 1,
                    ),
                    effects: [
                        new Points(3),
                        new CoinsFor(Bonus::Military, 1),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::Palace->value => new Card(
                    id: Id::Palace,
                    age: Age::III,
                    type: Type::Civilian,
                    cost: new Cost(
                        clay: 1,
                        stone: 1,
                        wood: 1,
                        glass: 2,
                    ),
                    effects: [
                        new Points(7),
                    ],
                ),
                Id::TownHall->value => new Card(
                    id: Id::TownHall,
                    age: Age::III,
                    type: Type::Civilian,
                    cost: new Cost(
                        stone: 3,
                        wood: 2,
                    ),
                    effects: [
                        new Points(7),
                    ],
                ),
                Id::Obelisk->value => new Card(
                    id: Id::Obelisk,
                    age: Age::III,
                    type: Type::Civilian,
                    cost: new Cost(
                        wood: 2,
                        glass: 1,
                    ),
                    effects: [
                        new Points(5),
                    ],
                ),
                Id::Fortifications->value => new Card(
                    id: Id::Fortifications,
                    age: Age::III,
                    type: Type::Military,
                    cost: new Cost(
                        stone: 2,
                        clay: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Military(2),
                    ],
                ),
                Id::SiegeWorkshop->value => new Card(
                    id: Id::SiegeWorkshop,
                    age: Age::III,
                    type: Type::Military,
                    cost: new Cost(
                        wood: 3,
                        glass: 1,
                    ),
                    effects: [
                        new Military(2),
                    ],
                ),
                Id::Circus->value => new Card(
                    id: Id::Circus,
                    age: Age::III,
                    type: Type::Military,
                    cost: new Cost(
                        clay: 2,
                        stone: 2,
                    ),
                    effects: [
                        new Military(2),
                    ],
                ),
                Id::University->value => new Card(
                    id: Id::University,
                    age: Age::III,
                    type: Type::Science,
                    cost: new Cost(
                        clay: 1,
                        glass: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Points(2),
                        new Science(Symbol::Astrology),
                    ],
                ),
                Id::Observatory->value => new Card(
                    id: Id::Observatory,
                    age: Age::III,
                    type: Type::Science,
                    cost: new Cost(
                        stone: 1,
                        papyrus: 2,
                    ),
                    effects: [
                        new Points(2),
                        new Science(Symbol::Astrology),
                    ],
                ),
                Id::Gardens->value => new Card(
                    id: Id::Gardens,
                    age: Age::III,
                    type: Type::Civilian,
                    cost: new Cost(
                        clay: 2,
                        wood: 2,
                    ),
                    effects: [
                        new Points(6),
                    ],
                ),
                Id::Pantheon->value => new Card(
                    id: Id::Pantheon,
                    age: Age::III,
                    type: Type::Civilian,
                    cost: new Cost(
                        clay: 1,
                        wood: 1,
                        papyrus: 2,
                    ),
                    effects: [
                        new Points(6),
                    ],
                ),
                Id::Senate->value => new Card(
                    id: Id::Senate,
                    age: Age::III,
                    type: Type::Civilian,
                    cost: new Cost(
                        clay: 2,
                        stone: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Points(5),
                    ],
                ),
                Id::Lighthouse->value => new Card(
                    id: Id::Lighthouse,
                    age: Age::III,
                    type: Type::Commercial,
                    cost: new Cost(
                        clay: 2,
                        glass: 1,
                    ),
                    effects: [
                        new Points(3),
                        new CoinsFor(Bonus::Commercial, 1),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::Arena->value => new Card(
                    id: Id::Arena,
                    age: Age::III,
                    type: Type::Commercial,
                    cost: new Cost(
                        clay: 1,
                        stone: 1,
                        wood: 1,
                    ),
                    effects: [
                        new Points(3),
                        new CoinsFor(Bonus::Wonder, 2),
                        new AdjustDiscardReward(),
                    ],
                ),
                Id::MerchantsGuild->value => new Card(
                    id: Id::MerchantsGuild,
                    age: Age::III,
                    type: Type::Guild,
                    cost: new Cost(
                        clay: 1,
                        wood: 1,
                        glass: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Guild(Bonus::Commercial, 1, 1),
                    ],
                ),
                Id::ShipOwnersGuild->value => new Card(
                    id: Id::ShipOwnersGuild,
                    age: Age::III,
                    type: Type::Guild,
                    cost: new Cost(
                        clay: 1,
                        stone: 1,
                        glass: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Guild(Bonus::Resources, 1, 1),
                    ],
                ),
                Id::BuildersGuild->value => new Card(
                    id: Id::BuildersGuild,
                    age: Age::III,
                    type: Type::Guild,
                    cost: new Cost(
                        stone: 2,
                        clay: 1,
                        wood: 1,
                        glass: 1,
                    ),
                    effects: [
                        new Guild(Bonus::Wonder, 2, 0),
                    ],
                ),
                Id::MagistratesGuild->value => new Card(
                    id: Id::MagistratesGuild,
                    age: Age::III,
                    type: Type::Guild,
                    cost: new Cost(
                        wood: 2,
                        clay: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Guild(Bonus::Civilian, 1, 1),
                    ],
                ),
                Id::ScientistsGuild->value => new Card(
                    id: Id::ScientistsGuild,
                    age: Age::III,
                    type: Type::Guild,
                    cost: new Cost(
                        clay: 2,
                        wood: 2,
                    ),
                    effects: [
                        new Guild(Bonus::Science, 1, 1),
                    ],
                ),
                Id::MoneyLendersGuild->value => new Card(
                    id: Id::MoneyLendersGuild,
                    age: Age::III,
                    type: Type::Guild,
                    cost: new Cost(
                        stone: 2,
                        wood: 2,
                    ),
                    effects: [
                        new Guild(Bonus::Coin, 1, 0),
                    ],
                ),
                Id::TacticiansGuild->value => new Card(
                    id: Id::TacticiansGuild,
                    age: Age::III,
                    type: Type::Guild,
                    cost: new Cost(
                        stone: 2,
                        clay: 1,
                        papyrus: 1,
                    ),
                    effects: [
                        new Guild(Bonus::Military, 1, 1),
                    ],
                ),
            ];
        }

        return self::$data;
    }
}
