<?php
namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class HelperFunction extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('generateReference', [$this, 'generateReference']),
        ];
    }

    public function generateReference($agentId,$rendezVousUserId,$contactId = null,$auditId = null)
    {
        // Your custom logic here
        $ref = "PBB-".$agentId."-".$rendezVousUserId;
        if(!is_null($contactId)){
            $ref.="-".$contactId;
        }
        if($auditId){
            $ref.="-".$auditId;
        }   
        return $ref;
    }
}
