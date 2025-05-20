<?php 
namespace App\Util;

class LittlePonailsConstant{
    public const DOCUMENT_STATUS = [
        "-1" =>"Invalide",
        "1" =>"Valide",
        "0" =>"En attente de validation",
    ];

    public const DOCUMENT_TYPE = [
        "1" => "Identité",
        "2" => "KBis",
    ];

    public const DOCUMENT_FORM_TYPE = [
        'identity'=> "Pièces d'identité",
        'kbis'=> 'KBis',
    ];
}   