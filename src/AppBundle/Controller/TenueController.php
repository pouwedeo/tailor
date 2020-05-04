<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Tenue;

class TenueController extends FOSRestController
{
    /**
     * @Rest\Get("/tenue")
     */
    public function getAllAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Tenue')->findAll();
        if (empty($restresult)) {
          return new View("pas de tenue(s)", Response::HTTP_NOT_FOUND);
     }else
        return $restresult;
    }


        /**
         * @Rest\Get("/tenue/{id}")
         */
        public function getOneAction($id)
        {
          $singleresult = $this->getDoctrine()->getRepository('AppBundle:Tenue')->findOneById($id);
          if (empty($singleresult)) {
          return new View("tenue non trouvé", Response::HTTP_NOT_FOUND);
          }
          else  return $singleresult;
        }




           /**
           * @Rest\Post("/tenue")
           */

          public function newAction(Tenue $tenue,Request $request)
          { 

          $em = $this->getDoctrine()->getManager();
          if (empty($tenue)) {
            return new View("tenue non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($tenue)){

            $_tenue = $this->getDoctrine()->getRepository('AppBundle:Tenue')->findOneById($tenue->getId());

            if($_tenue!=null){
          return new View(" Cette tenue existe déjà", Response::HTTP_FORBIDDEN);
            }else{
              $em->persist($tenue);
              $em->flush();
              return new View("Enregistrement ok", Response::HTTP_OK);

            }
            
          }
         
          }




            /**
           * @Rest\Put("/{id}/tenue")
           */

          public function updateAction(Tenue $tenue,Request $request)
          { 

          if (empty($tenue)) {
            return new View("tenue non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($tenue)){

            $_tenue = $this->getDoctrine()->getRepository('AppBundle:Tenue')->findOneById($tenue->getId());

            if($_tenue!=null){
              $this->getDoctrine()->getManager()->flush();

            }
            
          }
         
          }



        /**
      * @Rest\Delete("/tenue/{id}")
      */
    public function deleteAction($id)
    {
       
        $em = $this->getDoctrine()->getManager();
        $tenue = $this->getDoctrine()->getRepository('AppBundle:Tenue')->find($id);
      if (empty($tenue)) {
        return new View("tenue not found", Response::HTTP_NOT_FOUND);
      }
      else {
        $em->remove($tenue);
        $em->flush();
      }
        return new View("supprimé avec succès", Response::HTTP_OK);
      }
}
