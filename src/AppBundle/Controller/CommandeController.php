<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Commande;

class CommandeController extends FOSRestController
{
    /**
     * @Rest\Get("/commande")
     */
    public function getAllAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Commande')->findAll();
        if (empty($restresult)) {
          return new View("pas de commande(s)", Response::HTTP_NOT_FOUND);
     }else
        return $restresult;
    }


        /**
         * @Rest\Get("/commande/{id}")
         */
        public function getOneAction($id)
        {
          $singleresult = $this->getDoctrine()->getRepository('AppBundle:Commande')->findOneById($id);
          if (empty($singleresult)) {
          return new View("commande non trouvé", Response::HTTP_NOT_FOUND);
          }
          else  return $singleresult;
        }




           /**
           * @Rest\Post("/commande")
           */

          public function newAction(Commande $commande,Request $request)
          { 

          $em = $this->getDoctrine()->getManager();
          if (empty($commande)) {
            return new View("commande non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($commande)){

            $_commande = $this->getDoctrine()->getRepository('AppBundle:Commande')->findOneById($commande->getId());

            if($_commande!=null){
          return new View(" Cette commande existe déjà", Response::HTTP_FORBIDDEN);
            }else{
              $em->persist($commande);
              $em->flush();
              return new View("Enregistrement ok", Response::HTTP_OK);

            }
            
          }
         
          }




            /**
           * @Rest\Put("/{id}/commande")
           */

          public function updateAction(Commande $commande,Request $request)
          { 

          if (empty($commande)) {
            return new View("client non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($commande)){

            $_commande = $this->getDoctrine()->getRepository('AppBundle:Commande')->findOneById($commande->getId());

            if($_commande!=null){
              $this->getDoctrine()->getManager()->flush();

            }
            
          }
         
          }



        /**
      * @Rest\Delete("/commande/{id}")
      */
    public function deleteAction($id)
    {
        
      $em = $this->getDoctrine()->getManager();
        $commande = $this->getDoctrine()->getRepository('AppBundle:Commande')->find($id);
      if (empty($commande)) {
        return new View("commande not found", Response::HTTP_NOT_FOUND);
      }
      else {
        $em->remove($commande);
        $em->flush();
      }
        return new View("supprimé avec succès", Response::HTTP_OK);
      }
}
