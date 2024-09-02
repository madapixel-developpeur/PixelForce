<?php
namespace App\Util;

class FonctionnalitesTypeSecteur
{
    //standard
    const TYPE_STANDARD = 1;
    const FONCTIONNALITE_STANDARD_CONTACT = 'FONCTIONNALITE_STANDARD_CONTACT';
    const FONCTIONNALITE_STANDARD_FORMATION = 'FONCTIONNALITE_STANDARD_FORMATION';

    const TYPE_FONCTIONNALITES = [
        "type_".self::TYPE_STANDARD => [
            self::FONCTIONNALITE_STANDARD_CONTACT,
            self::FONCTIONNALITE_STANDARD_FORMATION
        ]
    ];

    const FONCTIONNALITE_LABELS = [
        self::FONCTIONNALITE_STANDARD_CONTACT => "Contact",
        self::FONCTIONNALITE_STANDARD_FORMATION => "Formation"
    ];
}