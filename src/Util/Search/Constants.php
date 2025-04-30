<?php 
namespace App\Util\Search;

class Constants {
    public const MATCH_ALL = 1;
    public const MATCH_START = 2;
    public const MATCH_END = 3;
    public const MATCH_EXACT = 4;

    public const SEP_AND = "AND";
    public const SEP_OR = "OR";

    public const PORTFOLIO_FOLDER = "professionnel/portfolio";
    public const MIN_RANK_MEEETING = 1;


    public const REFERENCE_PREFIX = "PRV";
    

    public static function getExcludedPathsForSectorCheckUp(array $givenPath = []): array
    {
        $commonPaths =  [
            '/agent/accueil',
            '/agent/secteur',
            '/myapi',
            '/chatutil',
            '/user',
            '/otp'
        ];
        return array_merge($commonPaths,$givenPath);
    }
}