<?php

namespace App\Services;

class DevList
{
    /**
     * list of all devs the engine should crawl
     * arcgames and reddit usernames
     *
     * devList
     *
     * @var array
     */
    public const DEVLIST = [
        [
            "name" => "badbotlimit",
            "arc" => "126158/badbotlimit",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "dextructoid",
            "arc" => "126174/dextructoid",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "lcdrmiller",
            "arc" => "125099/lcdrmiller",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "panderus",
            "arc" => "1318955/panderus",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "gentlemancrush",
            "arc" => "125100/gentlemancrush",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "strumslinger",
            "arc" => "98532/strumslinger",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "goatshark",
            "arc" => "1320795/goatshark",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "noworries",
            "arc" => "2843621/noworries%238859",
            "reddit" => "NoworriesDev",
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "pwlaughingtrendy",
            "arc" => "1770/pwlaughingtrendy",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "trailturtle",
            "arc" => "49488/trailturtle",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "ontheriver",
            "arc" => "1713637/ontheriver",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "asterdahl",
            "arc" => "1659280/asterdahl",
            "reddit" => "NWAsterdahlDev",
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "terramak",
            "arc" => "428327/terramak",
            "reddit" => "Terramak",
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "nisdiddums",
            "arc" => "419063/nisdiddums",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "rgutscheradev",
            "arc" => "2762919/rgutscheradev",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "trythree",
            "arc" => "1333700/trythree",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "angelcorlux",
            "arc" => "2771261/angelcorlux%236827",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "bbascomdev",
            "arc" => "2662703/bbascomdev",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "ashryver",
            "arc" => "2799887/ashryver%234991",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "crypticarkayne",
            "arc" => "451533/crypticarkayne",
            "reddit" => "CrypticArkayne",
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "dreadnaught",
            "arc" => "2801080/dreadnaught%235263",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "mimicking",
            "arc" => "2804886/mimicking%236533",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "chaidrin",
            "arc" => "2787970/chaidrin%232320",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "wakeupparamour",
            "arc" => "2784139/wakeupparamour%239775",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "xeltey",
            "arc" => "94885/xeltey",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "laserduck",
            "arc" => "1326961/laserduck",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "miasmat",
            "arc" => "1296144/miasmat",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "nitocris83",
            "arc" => "2829918/nitocris83",
            "reddit" => "Nitocris83",
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "ctatumdev",
            "arc" => "2786931/ctatumdev%236113",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "midnightlight",
            "arc" => "2845069/midnightlight%232361",
            "reddit" => "MidniteLight",
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "uimaven",
            "arc" => "1367938/uimaven",
            "reddit" => "UIMaven",
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "sgrantdev",
            "arc" => "2872700/sgrantdev%238718",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "ncoreadev",
            "arc" => "2876716/ncoreadev%234548",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "balanced",
            "arc" => "2876498/balanced%232849",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "sgrantdev",
            "arc" => "2877000/sgrantdev",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "crypticmapolis",
            "arc" => "1322418/crypticmapolis",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "bicyclops",
            "arc" => "2879990/bicyclops%233731",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "finefineday",
            "arc" => "2892709/finefineday%234940",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "scarabman",
            "arc" => "2662703/scarabman",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "thecourtfool",
            "arc" => "2908481/thecourtfool%235656",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "rlesterdev",
            "arc" => "2908477/rlesterdev%231958",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "jmcintyredev",
            "arc" => "2909109/jmcintyredev%233253",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "cwhitesidedev",
            "arc" => "2986868/cwhitesidedev%239752",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "cryptic39",
            "arc" => "2963242/cryptic39%238917",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "eminnerdev",
            "arc" => "2972703/eminnerdev%238159",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "rhroudadev",
            "arc" => "2953330/rhroudadev%235641",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "joebot",
            "arc" => "1322674/joebot%239387",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "dinothar",
            "arc" => "2962087/dinothar%233332",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "stormshade",
            "arc" => "141126/stormshade",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "trailturtle",
            "arc" => "49488/trailturtle",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "pwetrailturtle",
            "arc" => "443891/pwetrailturtle",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "cmpinpointerror",
            "arc" => "36593/cmpinpointerror",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "sominator",
            "arc" => "388963/sominator",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "dwightmc",
            "arc" => "469522/dwightmc",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "sroark",
            "arc" => "465034/sroark",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "akromatik",
            "arc" => "1764/akromatik",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "yetweallfalldown",
            "arc" => "121752/yetweallfalldown",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "percemer",
            "arc" => "125023/percemer",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "ambassadorkael",
            "arc" => "2831597/ambassadorkael%236946",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "rwhitedev",
            "arc" => "2952138/rwhitedev%237348",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "lassor",
            "arc" => "2900450/lassor",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "crypticpop",
            "arc" => "3043657/crypticpop%237861",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "avathar",
            "arc" => "3022145/avathar%232753",
            "reddit" => false,
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "SKing",
            "arc" => false,
            "reddit" => "SKing_dev",
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "AndyMaurer",
            "arc" => false,
            "reddit" => "AndyMaurerAtCryptic",
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "Tails",
            "arc" => false,
            "reddit" => "Cryptic_Tails",
            "enabled" => true,
            "historyenabled" => true,
        ],
        [
            "name" => "digita1hound",
            "arc" => false,
            "reddit" => "digita1hound",
            "enabled" => true,
            "historyenabled" => true,
        ]
    ];

    /**
     * get data based on name
     *
     * @param string $name
     *
     * @return array
     */
    private static function getDevData(string $name): array
    {
        $devData = null;
        foreach (self::DEVLIST as $dev) {
            if ($dev['name'] === $name) {
                $devData = $dev;
                break;
            }
        }

        if ($devData === null) {
            throw new \Exception("no dev record with provided name " . $name);
        }

        return $devData;
    }

    /**
     * get arc usernames from current dev
     *
     * @param string $name
     *
     * @return array
     */
    public static function getArcgamesDevData(string $name): array
    {
        return explode("/", self::getDevData($name)['arc']);
    }

    /**
     * get arc usernames from current dev
     *
     * @param string $name
     *
     * @return string
     */
    public static function getRedditUsername(string $name): string
    {
        return self::getDevData($name)['reddit'];
    }
}
