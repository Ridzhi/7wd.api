<?php /** @noinspection PhpNamedArgumentsWithChangedOrderInspection */

namespace App\Domain\Game\Wonder;

use App\Domain\Game\Card\Type;
use App\Domain\Game\Cost;
use App\Domain\Game\Discount\Context;
use App\Domain\Game\Discount\Discount;
use App\Domain\Game\Effect\BurnCard;
use App\Domain\Game\Effect\Coins;
use App\Domain\Game\Effect\Discounter;
use App\Domain\Game\Effect\Fine;
use App\Domain\Game\Effect\Military;
use App\Domain\Game\Effect\PickDiscardedCard;
use App\Domain\Game\Effect\PickRandomToken;
use App\Domain\Game\Effect\PickReturnedCards;
use App\Domain\Game\Effect\PickTopLineCard;
use App\Domain\Game\Effect\PlayAgain;
use App\Domain\Game\Effect\Points;
use App\Domain\Game\Resource\Id as Rid;

class Repository
{
    private array $data;

    public function __construct()
    {
        $this->data = [
            Id::TheAppianWay->value => new Wonder(
                id: Id::TheAppianWay,
                cost: new Cost(
                    papyrus: 1,
                    clay: 2,
                    stone: 2,
                ),
                effects: [
                    new Coins(3),
                    new Fine(3),
                    new PlayAgain(),
                    new Points(3),
                ],
            ),
            Id::CircusMaximus->value => new Wonder(
                id: Id::CircusMaximus,
                cost: new Cost(
                    glass: 1,
                    wood: 1,
                    stone: 2,
                ),
                effects: [
                    new BurnCard(Type::ManufacturedGoods),
                    new Military(1, false),
                    new Points(3),
                ],
            ),
            Id::TheColossus->value => new Wonder(
                id: Id::TheColossus,
                cost: new Cost(
                    glass: 1,
                    clay: 3,
                ),
                effects: [
                    new Military(2, false),
                    new Points(3),
                ],
            ),
            Id::TheGreatLibrary->value => new Wonder(
                id: Id::TheGreatLibrary,
                cost: new Cost(
                    papyrus: 1,
                    glass: 1,
                    wood: 3,
                ),
                effects: [
                    new PickRandomToken(),
                    new Points(4),
                ],
            ),
            Id::TheGreatLighthouse->value => new Wonder(
                id: Id::TheGreatLighthouse,
                cost: new Cost(
                    papyrus: 2,
                    stone: 1,
                    wood: 1,
                ),
                effects: [
                    new Discounter(new Discount(
                        Context::Global,
                        1,
                        Rid::Clay,
                        Rid::Wood,
                        Rid::Stone,
                    )),
                    new Points(4),
                ],
            ),
            Id::TheHangingGardens->value => new Wonder(
                id: Id::TheHangingGardens,
                cost: new Cost(
                    papyrus: 1,
                    glass: 1,
                    wood: 2,
                ),
                effects: [
                    new Coins(6),
                    new PlayAgain(),
                    new Points(3),
                ],
            ),
            Id::TheMausoleum->value => new Wonder(
                id: Id::TheMausoleum,
                cost: new Cost(
                    papyrus: 1,
                    glass: 2,
                    clay: 2,
                ),
                effects: [
                    new PickDiscardedCard(),
                    new Points(2),
                ],
            ),
            Id::Piraeus->value => new Wonder(
                id: Id::Piraeus,
                cost: new Cost(
                    clay: 1,
                    stone: 1,
                    wood: 2,
                ),
                effects: [
                    new Discounter(new Discount(
                        Context::Global,
                        1,
                        Rid::Glass,
                        Rid::Papyrus,
                    )),
                    new PlayAgain(),
                    new Points(2),
                ],
            ),
            Id::ThePyramids->value => new Wonder(
                id: Id::ThePyramids,
                cost: new Cost(
                    papyrus: 1,
                    stone: 3,
                ),
                effects: [
                    new Points(9),
                ],
            ),
            Id::TheSphinx->value => new Wonder(
                id: Id::TheSphinx,
                cost: new Cost(
                    glass: 2,
                    clay: 1,
                    stone: 1,
                ),
                effects: [
                    new PlayAgain(),
                    new Points(6),
                ],
            ),
            Id::TheStatueOfZeus->value => new Wonder(
                id: Id::TheStatueOfZeus,
                cost: new Cost(
                    papyrus: 2,
                    clay: 1,
                    wood: 1,
                    stone: 1,
                ),
                effects: [
                    new BurnCard(Type::RawMaterials),
                    new Military(1, false),
                    new Points(3),
                ],
            ),
            Id::TheTempleOfArtemis->value => new Wonder(
                id: Id::TheTempleOfArtemis,
                cost: new Cost(
                    papyrus: 1,
                    glass: 1,
                    stone: 1,
                    wood: 1,
                ),
                effects: [
                    new Coins(12),
                    new PlayAgain(),
                ],
            ),
            Id::Messe->value => new Wonder(
                id: Id::Messe,
                cost: new Cost(
                    glass: 1,
                    papyrus: 1,
                    wood: 1,
                    clay: 2,
                ),
                effects: [
                    new PickTopLineCard(),
                    new Points(2),
                ],
            ),
            Id::StatueOfLiberty->value => new Wonder(
                id: Id::StatueOfLiberty,
                cost: new Cost(
                    glass: 1,
                    papyrus: 1,
                    clay: 1,
                    stone: 1,
                    wood: 1,
                ),
                effects: [
                    new PickReturnedCards(),
                    new Points(5),
                ],
            ),
        ];
    }

    /**
     * @param Id $wid
     * @return Wonder
     */
    public function get(Id $wid): Wonder
    {
        return $this->data[$wid->value];
    }

    /**
     * @return Wonder[]
     */
    public function getAll(): array
    {
        return $this->data;
    }
}
