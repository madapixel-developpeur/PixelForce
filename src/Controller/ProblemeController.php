<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Audit;
use App\Entity\Secteur;
use App\Form\AuditType;
use App\Entity\Probleme;
use App\Form\ProblemeType;
use App\Form\UserLoginType;
use App\Entity\CoachSecteur;
use App\Manager\UserManager;
use App\Manager\EntityManager;
use App\Repository\UserRepository;
use App\Services\AgentSecteurService;
use App\Repository\ProblemeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/probleme")
*/
class ProblemeController extends AbstractController
{
    protected $repoUser;
    protected $problemeRepository;
    protected $entityManager;
    protected $userManager;


    public function __construct(UserRepository $repoUser,
                                EntityManager $entityManager,
                                UserManager $userManager,
                                ProblemeRepository $problemeRepository
                            )
    {
        $this->repoUser = $repoUser;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->problemeRepository = $problemeRepository;
    }

    /**
     * @Route("/{id}/liste", name="admin_probleme_list")
     */
    public function probleme_list(Audit $audi,Request $request, PaginatorInterface $paginator)
    {
       
        return $this->render('user_category/admin/audit/list_audit.html.twig', [
            //'probleme' => $probleme,
        ]);
    }

     /**
     * @Route("/{id}/view", name="probleme_view")
     */
    public function probleme_view(Probleme $probleme,Request $request, AgentSecteurService $agentSecteurService, PaginatorInterface $paginator)
    {     
        return $this->render('user_category/agent/probleme/view_probleme.html.twig', [
            'probleme' =>$probleme
        ]);
    }

    /**
     * @Route("/{id}/add", name="probleme_add")
     */
    public function admin_probleme_add(Audit $audit,Request $request)
    {
        $probleme = new Probleme();
        $formUser = $this->createForm(ProblemeType::class, $probleme);
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $probleme->setAudit($audit);
            $probleme->setAuteur($this->getUser());
            $probleme->setIsActive(Probleme::ACTIVE_YES);
            $probleme->setDateAjout(new \DateTime());
            $this->entityManager->save($probleme);

            $this->addFlash('success', "Nouveau problème enregistré avec succès");
            return $this->redirectToRoute('audit_view', ['id' =>  $audit->getId()]);    
        }

        return $this->render('user_category/agent/probleme/add_probleme.html.twig', [
            'formUser' => $formUser->createView(),
            'audit' => $audit,
            'button' => 'Ajouter'
        ]);    
    }

    /**
     * @Route("/admin/ambassadeur/{id}/edit", name="probleme_edit")
     */
    public function admin_probleme_edit(Request $request,Probleme $probleme)
    {

        $formUser = $this->createForm(ProblemeType::class, $probleme);
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
           
            $this->entityManager->save($probleme);

            $this->addFlash('success', "Problème mis à jour avec succès");
            return $this->redirectToRoute('audit_view', ['id' =>  $probleme->getAudit()->getId()]);    
        }

        return $this->render('user_category/agent/probleme/edit_probleme.html.twig', [
            'formUser' => $formUser->createView(),
            'audit' => $probleme->getAudit(),
            'button' => 'Modifier'
        ]);    
    }
    /**
     * @Route("/{id}/delete", name="probleme_delete")
     */
    public function admin_probleme_delete( Probleme $probleme)
    {
            $probleme->setIsActive(Probleme::ACTIVE_NO);
            $this->entityManager->save($probleme);
            $this->addFlash('success', "Suppression Probleme effectuée avec succès");
            return $this->redirectToRoute('audit_view', ['id' => $probleme->getAudit()->getId()]);    
           
    }


    
   
}
