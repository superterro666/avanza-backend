<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use EntityBundle\Entity\Portfolio;

class PortfolioController extends Controller {

     public function setPortfolioAction(Request $request) {
        $error = $this->get('error.service');
        $json = $error->parsePost($request);
        
        $utils = $this->get('generate.login.service');

        if ($json) {
            
            $titulo = $json->titulo ?? false;
            $texto = $json->texto ?? false;

            if ($titulo && $texto) {
                try {
                    $em = $this->getDoctrine()->getManager();

                    $portfolio = new Portfolio();
                    $portfolio->setFecha(new \DateTime());
                    $portfolio->setTitulo($titulo);
                    $portfolio->setTexto($texto);
                    $portfolio->setImagen(null);

                    $em->persist($portfolio);
                    $em->flush();

                    $dql = "SELECT b.titulo, b.texto, b.id, b.imagen  FROM EntityBundle:Portfolio b ORDER BY b.fecha DESC";

                    $query = $em->createQuery($dql);
                    $result = $query->getResult();

                    return new JsonResponse(array('code' => 200, 'portfolios' => $result));
                } catch (\Doctrine\DBAL\Exception $e) {

                    return new JsonResponse($error->dbError($e->getMessage()));
                }

               
            }
             return new JsonResponse($error->dataError($json));
        }
        return new JsonResponse($error->tokenError());
    }

    public function updatePortfolioAction(Request $request) {
        $error = $this->get('error.service');
        $json = $error->parsePost($request);

        if ($json) {

            $titulo = $json->titulo ?? false;
            $texto = $json->texto ?? false;
            $id = $json->id ?? false;


            if ($titulo && $texto && $id) {

                try {
                    $em = $this->getDoctrine()->getManager();

                    $portfolio = $em->getRepository("EntityBundle:Portfolio")->findOneBy(array('id' => $json->id));

                    $portfolio->setTitulo($titulo);
                    $portfolio->setTexto($texto);
                    $em->persist($portfolio);
                    $em->flush();

                    $dql = "SELECT b.titulo, b.texto, b.id, b.imagen  FROM EntityBundle:Portfolio b ORDER BY b.fecha DESC";

                    $query = $em->createQuery($dql);
                    $result = $query->getResult();

                    return new JsonResponse(array('code' => 200, 'portfolios' => $result));
                } catch (\Doctrine\DBAL\Exception $e) {

                    return new JsonResponse($error->dbError($e->getMessage()));
                }
            }

            return new JsonResponse($error->dataError($json));
        }
        return new JsonResponse($error->tokenError());
    }

    public function deletePortfolioAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $id = $request->query->get('id') ?? false;
            if ($id) {
                $em = $this->getDoctrine()->getManager();
                try {
                    $portfolio = $em->getRepository("EntityBundle:Portfolio")->findOneBy(array('id' => $id));
                    if (count($portfolio) > 0) {


                        $em->remove($portfolio);
                        $em->flush();
                        $dql = "SELECT b.titulo, b.texto, b.id, b.imagen  FROM EntityBundle:Portfolio b ORDER BY b.fecha DESC";

                        $query = $em->createQuery($dql);
                        $result = $query->getResult();

                        return new JsonResponse(array('code' => 200, 'portfolios' => $result));
                    }
                    return new JsonResponse($error->dataError($user));
                } catch (\Doctrine\DBAL\Exception $e) {

                    return new JsonResponse($error->dbError($e));
                }
            }
            return new JsonResponse($error->dataError($user));
        }
    }

    public function viewPortfolioAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $id = $request->query->get('id') ?? false;
            if ($id) {
                $em = $this->getDoctrine()->getManager();
                $dql = "SELECT b.titulo, b.texto, b.id , b.imagen FROM EntityBundle:Portfolio b WHERE b.id =:id";
                try {
                    $query = $em->createQuery($dql)->setParameter('id', $id);
                    $result = $query->getOneOrNullResult();
                    if (count($result) > 0)
                        return new JsonResponse(array('code'=>200,'portfolio'=>$result));
                    return new JsonResponse($error->dataError($result));
                } catch (\Doctrine\DBAL\Exception $e) {
                    return new JsonResponse($error->dbError($e));
                }
            }
            return new JsonResponse($error->dataError());
        }
        return new JsonResponse($error->tokenError());
    }

    public function viewsPortfolioAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $em = $this->getDoctrine()->getManager();
            $dql = "SELECT b.titulo, b.texto, b.id, b.imagen FROM EntityBundle:Portfolio b ORDER BY b.fecha DESC";
            try {
                $query = $em->createQuery($dql);
                $result = $query->getResult();

                return new JsonResponse(array('code' => 200, 'portfolios' => $result));
            } catch (\Doctrine\DBAL\Exception $e) {
                return new JsonResponse($error->dbError($e));
            }
        }
        return new JsonResponse($error->tokenError());
    }
    
    public function uploadPortfolioAction(Request $request){
      $error = $this->get('error.service');
      $fileTask = $this->get('file.task.service');
      $image = $this->get('app.api.simpleimage');
      $json = $error->parsePost($request); 
      
      $files =   $request->files->get('imagen');
      $id = $request->get('id') ?? false;
      
       if(!empty($files) || $files != null || !$id){
           
            $em = $this->getDoctrine()->getManager();
            $url = 'uploads/images/';
            $img = $fileTask->getExtension($files, $url);
            $image->load( $url. $img);
            $image->resize(450, 450);
            $image->save($url . $img);
            
            try{
                $img_portfolio = $em->getRepository("EntityBundle:Portfolio")->find($id);
                $img_portfolio->setImagen($img);
                $em->persist($img_portfolio);
                $em->flush();
                
            }catch(\Doctrine\DBAL\Exception $e){
                return new JsonResponse($error->dbError($e));
            }
            
            
            return new JsonResponse($img);
            
       }else{
           
           return new JsonResponse($error->dataError($id));
       }      
    }


}
