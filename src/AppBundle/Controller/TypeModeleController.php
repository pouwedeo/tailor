<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\TypeModele;

class TypeModeleController extends FOSRestController
{
    /**
     * @Rest\Get("/typemodele")
     */
    public function getAllAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:TypeModele')->findAll();
        if (empty($restresult)) {
          return new View("pas de typemodele(s)", Response::HTTP_NOT_FOUND);
     }else
        return $restresult;
    }


        /**
         * @Rest\Get("/typemodele/{id}")
         */
        public function getOneAction($id)
        {
          $singleresult = $this->getDoctrine()->getRepository('AppBundle:TypeModele')->findOneById($id);
          if (empty($singleresult)) {
          return new View("typemodele non trouvé", Response::HTTP_NOT_FOUND);
          }
          else  return $singleresult;
        }




           /**
           * @Rest\Post("/TypeModele")
           */

          public function newAction(TypeModele $typemodele,Request $request)
          { 

          $em = $this->getDoctrine()->getManager();
          if (empty($typemodele)) {
            return new View("TypeModele non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($typemodele)){

            $_typemodele = $this->getDoctrine()->getRepository('AppBundle:TypeModele')->findOneById($typemodele->getId());

            if($_typemodele!=null){
          return new View(" Ce TypeModele existe déjà", Response::HTTP_FORBIDDEN);
            }else{
              $em->persist($typemodele);
              $em->flush();
              return new View("Enregistrement ok", Response::HTTP_OK);

            }
            
          }
         
          }




            /**
           * @Rest\Put("/{id}/typemodele")
           */

          public function updateAction(TypeModele $typemodele,Request $request)
          { 

          if (empty($typemodele)) {
            return new View("TypeModele non trouvé", Response::HTTP_NOT_FOUND);
          } elseif(!empty($typemodele)){

            $_typemodele = $this->getDoctrine()->getRepository('AppBundle:TypeModele')->findOneById($typemodele->getId());

            if($_typemodele!=null){
              $this->getDoctrine()->getManager()->flush();

            }
            
          }
         
          }



        /**
      * @Rest\Delete("/typemodele/{id}")
      */
    public function deleteAction($id)
    {
       
        $em = $this->getDoctrine()->getManager();
        $typemodele = $this->getDoctrine()->getRepository('AppBundle:TypeModele')->find($id);
      if (empty($typemodele)) {
        return new View("TypeModele not found", Response::HTTP_NOT_FOUND);
      }
      else {
        $em->remove($typemodele);
        $em->flush();
      }
        return new View("supprimé avec succès", Response::HTTP_OK);
      }
}
