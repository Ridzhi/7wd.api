<?php

namespace App\Domain\Game\Card;

enum Id: int
{
    case Null = 0;

    case LumberYard = 100;
    case LoggingCamp = 101;
    case ClayPool = 102;
    case ClayPit = 103;
    case Quarry = 104;
    case StonePit = 105;
    case GlassWorks = 106;
    case Press = 107;
    case GuardTower = 108;
    case Workshop = 109;
    case Apothecary = 110;
    case StoneReserve = 111;
    case ClayReserve = 112;
    case WoodReserve = 113;
    case Stable = 114;
    case Garrison = 115;
    case Palisade = 116;
    case Scriptorium = 117;
    case Pharmacist = 118;
    case Theater = 119;
    case Altar = 120;
    case Baths = 121;
    case Tavern = 122;

    case SawMill = 200;
    case BrickYard = 201;
    case ShelfQuarry = 202;
    case GlassBlower = 203;
    case DryingRoom = 204;
    case Walls = 205;
    case Forum = 206;
    case Caravansery = 207;
    case CustomHouse = 208;
    case CourtHouse = 209;
    case HorseBreeders = 210;
    case Barracks = 211;
    case ArcheryRange = 212;
    case ParadeGround = 213;
    case Library = 214;
    case Dispensary = 215;
    case School = 216;
    case Laboratory = 217;
    case Statue = 218;
    case Temple = 219;
    case Aqueduct = 220;
    case Rostrum = 221;
    case Brewery = 222;

    case Arsenal = 300;
    case Pretorium = 301;
    case Academy = 302;
    case Study = 303;
    case ChamberOfCommerce = 304;
    case Port = 305;
    case Armory = 306;
    case Palace = 307;
    case TownHall = 308;
    case Obelisk = 309;
    case Fortifications = 310;
    case SiegeWorkshop = 311;
    case Circus = 312;
    case University = 313;
    case Observatory = 314;
    case Gardens = 315;
    case Pantheon = 316;
    case Senate = 317;
    case Lighthouse = 318;
    case Arena = 319;

    case MerchantsGuild = 400;
    case ShipOwnersGuild = 401;
    case BuildersGuild = 402;
    case MagistratesGuild = 403;
    case ScientistsGuild = 404;
    case MoneyLendersGuild = 405;
    case TacticiansGuild = 406;
}
