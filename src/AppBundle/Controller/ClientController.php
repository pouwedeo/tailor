<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Client;

class ClientController extends FOSRestController
{
    /**
     * @Rest\Get("/client")
     */
    public function getAllAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:Client')->findAll();
        if (empty($restresult)) {
          return new View("pas de client(s)", Response::HTTP_NOT_FOUND);
     }else
        return $restresult;
    }


        /**
         * @Rest\Get("/client/{id}")
         */
        public function getOneAction($id)
        {
          $singleresult = $this->getDoctrine()->getRepository('AppBundle:Client')->findOneById($id);
          if (empty($singleresult)) {
          return new View("client non trouvé", Response::HTTP_NOT_FOUND);
          }
          else  return $singleresult;
        }




           /**
           * @Rest\Post("/client")
           */

          public function newAction(Client $client,Request $request)
          { 

          $em = $this->getDoctrine()->getManager();
          if (empty($client)) {
            return new View("client non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($client)){

            $_client = $this->getDoctrine()->getRepository('AppBundle:Client')->findOneById($client->getId());

            if($_client!=null){
          return new View(" Ce client existe déjà", Response::HTTP_FORBIDDEN);
            }else{
              $em->persist($client);
              $em->flush();
              return new View("Enregistrement ok", Response::HTTP_OK);

            }
            
          }
         
          }




            /**
           * @Rest\Put("/{id}/client")
           */

          public function updateAction(Client $client,Request $request)
          { 

          if (empty($client)) {
            return new View("client non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($client)){

            $_client = $this->getDoctrine()->getRepository('AppBundle:Client')->findOneById($client->getId());

            if($_client!=null){
              $this->getDoctrine()->getManager()->flush();

            }
            
          }
         
          }



        /**
      * @Rest\Delete("/client/{id}")
      */
    public function deleteAction($id)
    {
        
      $em = $this->getDoctrine()->getManager();
        $client = $this->getDoctrine()->getRepository('AppBundle:Client')->find($id);
      if (empty($client)) {
        return new View("client not found", Response::HTTP_NOT_FOUND);
      }
      else {
        $em->remove($client);
        $em->flush();
      }
        return new View("supprimé avec succès", Response::HTTP_OK);
      }
}
