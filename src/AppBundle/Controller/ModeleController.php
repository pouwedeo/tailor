<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Modele;

class ModeleController extends FOSRestController
{
    /**
     * @Rest\Get("/modele")
     */
    public function getAllAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Modele')->findAll();
        if (empty($restresult)) {
          return new View("pas de modele(s)", Response::HTTP_NOT_FOUND);
     }else
        return $restresult;
    }


        /**
         * @Rest\Get("/modele/{id}")
         */
        public function getOneAction($id)
        {
          $singleresult = $this->getDoctrine()->getRepository('AppBundle:Modele')->findOneById($id);
          if (empty($singleresult)) {
          return new View("modele non trouvé", Response::HTTP_NOT_FOUND);
          }
          else  return $singleresult;
        }




           /**
           * @Rest\Post("/modele")
           */

          public function newAction(Modele $modele,Request $request)
          { 

          $em = $this->getDoctrine()->getManager();
          if (empty($modele)) {
            return new View("modele non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($modele)){

            $_modele = $this->getDoctrine()->getRepository('AppBundle:Modele')->findOneById($modele->getId());

            if($_modele!=null){
          return new View(" Ce modele existe déjà", Response::HTTP_FORBIDDEN);
            }else{
              $em->persist($modele);
              $em->flush();
              return new View("Enregistrement ok", Response::HTTP_OK);

            }
            
          }
         
          }




            /**
           * @Rest\Put("/{id}/modele")
           */

          public function updateAction(Modele $modele,Request $request)
          { 

          if (empty($modele)) {
            return new View("modele non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($modele)){

            $_modele = $this->getDoctrine()->getRepository('AppBundle:Modele')->findOneById($modele->getId());

            if($_modele!=null){
              $this->getDoctrine()->getManager()->flush();

            }
            
          }
         
          }



        /**
      * @Rest\Delete("/modele/{id}")
      */
    public function deleteAction($id)
    {
       
        $em = $this->getDoctrine()->getManager();
        $modele = $this->getDoctrine()->getRepository('AppBundle:Modele')->find($id);
      if (empty($modele)) {
        return new View("modele not found", Response::HTTP_NOT_FOUND);
      }
      else {
        $em->remove($modele);
        $em->flush();
      }
        return new View("supprimé avec succès", Response::HTTP_OK);
      }
}
