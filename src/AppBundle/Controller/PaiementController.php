<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Paiement;

class PaiementController extends FOSRestController
{
    /**
     * @Rest\Get("/paiement")
     */
    public function getAllAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Paiement')->findAll();
        if (empty($restresult)) {
          return new View("pas de paiement(s)", Response::HTTP_NOT_FOUND);
     }else
        return $restresult;
    }


        /**
         * @Rest\Get("/paiement/{id}")
         */
        public function getOneAction($id)
        {
          $singleresult = $this->getDoctrine()->getRepository('AppBundle:Paiement')->findOneById($id);
          if (empty($singleresult)) {
          return new View("paiement non trouvé", Response::HTTP_NOT_FOUND);
          }
          else  return $singleresult;
        }




           /**
           * @Rest\Post("/paiement")
           */

          public function newAction(Paiement $paiement,Request $request)
          { 

          $em = $this->getDoctrine()->getManager();
          if (empty($paiement)) {
            return new View("Paiement non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($paiement)){

            $_paiement = $this->getDoctrine()->getRepository('AppBundle:Paiement')->findOneById($paiement->getId());

            if($_paiement!=null){
          return new View(" Ce Paiement existe déjà", Response::HTTP_FORBIDDEN);
            }else{
              $em->persist($paiement);
              $em->flush();
              return new View("Enregistrement ok", Response::HTTP_OK);

            }
            
          }
         
          }




            /**
           * @Rest\Put("/{id}/paiement")
           */

          public function updateAction(Paiement $paiement,Request $request)
          { 

          if (empty($paiement)) {
            return new View("Paiement non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($paiement)){

            $_paiement = $this->getDoctrine()->getRepository('AppBundle:Paiement')->findOneById($paiement->getId());

            if($_paiement!=null){
              $this->getDoctrine()->getManager()->flush();

            }
            
          }
         
          }



        /**
      * @Rest\Delete("/paiement/{id}")
      */
    public function deleteAction($id)
    {
       
        $em = $this->getDoctrine()->getManager();
        $paiement = $this->getDoctrine()->getRepository('AppBundle:Paiement')->find($id);
      if (empty($paiement)) {
        return new View("Paiement not found", Response::HTTP_NOT_FOUND);
      }
      else {
        $em->remove($paiement);
        $em->flush();
      }
        return new View("supprimé avec succès", Response::HTTP_OK);
      }
}
