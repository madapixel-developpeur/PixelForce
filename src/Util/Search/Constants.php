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

    public const LPN_PIXELFORCE_PROVIDER='PIXELFORCE';


    public const DEFAULT_LPN_PASSWORD='Pa$$word!'; 

    public const DEFAULT_LPN_LEGAL_STATUS = "REVENDEUR";

    public const PBB_CATALOGUES_SERVICES = ['SEO','SEA','SOCIAL MEDIA MANAGER','WEB DEVELOPMENT','DESIGN','TECHLEAD'];

    public const NUMBER_OF_USER_TO_SHOW = 10;
    // const SERVICE = [
    //     'SEO' => 1,
    //     'DEV_WEB' => 2,
    //     'SOCIAL_MEDIA' => 3,
    //     'CONC_GRAPH' => 4,
    //     'GOOGLE_ADWORDS' => 5,
    //     'DEV_APP_MOB' => 6
    // ];

    public const PACKAGE_PERIOD = [
        'MENSUEL' => 'Mensuel',
        'ANNUEL' => 'Annuel',
        'QUOTIDIEN' => 'Quotidien'
    ];

    public static function getExcludedPathsForSectorCheckUp(array $givenPath = []): array
    {
        $commonPaths =  [
            '/agent/accueil',
            '/agent/secteur',
            '/myapi',
            '/chatutil',
            '/user',
            '/otp',
            '/agent/view-share'
        ];
        return array_merge($commonPaths,$givenPath);
    }
}