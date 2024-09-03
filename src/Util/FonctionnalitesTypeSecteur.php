<?php
namespace App\Util;

class FonctionnalitesTypeSecteur
{
    //common
    const TYPE_STANDARD = 1;
    const FONCTIONNALITE_COMMON_CONTACT = 'FONCTIONNALITE_COMMON_CONTACT';
    const FONCTIONNALITE_COMMON_FORMATION = 'FONCTIONNALITE_COMMON_FORMATION';

    const FONCTIONNALITE_COMMON_AGENDA = 'FONCTIONNALITE_COMMON_AGENDA';

    const FONCTIONNALITE_COMMON_TRANSACTION = 'FONCTIONNALITE_COMMON_TRANSACTION';

    const FONCTIONNALITE_COMMON_RDV = 'FONCTIONNALITE_COMMON_RDV';

    const FONCTIONNALITE_COMMON_AUDIT = 'FONCTIONNALITE_COMMON_AUDIT';

    //standard
    const FONCTIONNALITE_STANDARD_PRODUIT = 'FONCTIONNALITE_STANDARD_PRODUIT';
    const FONCTIONNALITE_STANDARD_VENTE = 'FONCTIONNALITE_COMMON_VENTE';

    const TYPE_FONCTIONNALITES = [
        "common" => [
            self::FONCTIONNALITE_COMMON_CONTACT,
            self::FONCTIONNALITE_COMMON_FORMATION,
            self::FONCTIONNALITE_COMMON_AGENDA,
            self::FONCTIONNALITE_COMMON_TRANSACTION,
            self::FONCTIONNALITE_COMMON_RDV,
            self::FONCTIONNALITE_COMMON_AUDIT
        ],
        "type_" . self::TYPE_STANDARD => [
            self::FONCTIONNALITE_STANDARD_PRODUIT,
            self::FONCTIONNALITE_STANDARD_VENTE
        ]
    ];

    const FONCTIONNALITE_LABELS = [
        self::FONCTIONNALITE_COMMON_CONTACT => "Contact",
        self::FONCTIONNALITE_COMMON_FORMATION => "Formation",
        self::FONCTIONNALITE_COMMON_AGENDA => "Agenda",
        self::FONCTIONNALITE_COMMON_TRANSACTION => "Transaction",
        self::FONCTIONNALITE_COMMON_RDV => "Rendez-Vous",
        self::FONCTIONNALITE_COMMON_AUDIT => "Audit",
        self::FONCTIONNALITE_STANDARD_PRODUIT => "Produit",
        self::FONCTIONNALITE_STANDARD_VENTE => "Vente",
    ];

    public static function getFonctionnalites($typeId)
    {
        $result = array_merge([], self::TYPE_FONCTIONNALITES["common"]);
        if (isset(self::TYPE_FONCTIONNALITES["type_" . $typeId]))
            $result = array_merge($result, self::TYPE_FONCTIONNALITES["type_" . $typeId]);
        return $result;
    }

    public static function getFonctionnaliteLabels($typeId)
    {
        $fonct = self::getFonctionnalites($typeId);
        $result = [];
        foreach ($fonct as $f) {
            $result[self::FONCTIONNALITE_LABELS[$f]] = $f;
        }
        return $result;
    }
}