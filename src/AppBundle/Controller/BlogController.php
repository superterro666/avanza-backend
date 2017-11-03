<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use EntityBundle\Entity\Blog;

class BlogController extends Controller {

    public function setBlogAction(Request $request) {
        $error = $this->get('error.service');
        $json = $error->parsePost($request);
        $utils = $this->get('generate.login.service');

        if ($json) {
            $titulo = $json->titulo ?? false;
            $texto = $json->texto ?? false;

            if ($texto && $titulo) {
                try {
                    $em = $this->getDoctrine()->getManager();

                    $blog = new Blog();
                    $blog->setFecha(new \DateTime());
                    $blog->setTitulo($titulo);
                    $blog->setTexto($texto);

                    $em->persist($blog);
                    $em->flush();

                    $dql = "SELECT b.titulo, b.texto, b.id FROM EntityBundle:Blog b ORDER BY b.fecha DESC";

                    $query = $em->createQuery($dql);
                    $result = $query->getResult();

                    return new JsonResponse(array('code' => 200, 'blogs' => $result));
                } catch (\Doctrine\DBAL\Exception $e) {

                    return new JsonResponse($error->dbError($e->getMessage()));
                }

                return new JsonResponse($error->dataError($json));
            }
        }
        return new JsonResponse($error->tokenError());
    }

    public function updateBlogAction(Request $request) {
        $error = $this->get('error.service');
        $json = $error->parsePost($request);

        if ($json) {

            $titulo = $json->titulo ?? false;
            $texto = $json->texto ?? false;
            $id = $json->id ?? false;


            if ($titulo && $texto && $id) {

                try {
                    $em = $this->getDoctrine()->getManager();

                    $blog = $em->getRepository("EntityBundle:Blog")->findOneBy(array('id' => $json->id));

                    $blog->setTitulo($titulo);
                    $blog->setTexto($texto);
                    $em->persist($blog);
                    $em->flush();

                    $dql = "SELECT b.titulo, b.texto, b.id FROM EntityBundle:Blog b ORDER BY b.fecha DESC";

                    $query = $em->createQuery($dql);
                    $result = $query->getResult();

                    return new JsonResponse(array('code' => 200, 'blogs' => $result));
                } catch (\Doctrine\DBAL\Exception $e) {

                    return new JsonResponse($error->dbError($e->getMessage()));
                }
            }

            return new JsonResponse($error->dataError($json));
        }
        return new JsonResponse($error->tokenError());
    }

    public function deleteBlogAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $id = $request->query->get('id') ?? false;
            if ($id) {
                $em = $this->getDoctrine()->getManager();
                try {
                    $blog = $em->getRepository("EntityBundle:Blog")->findOneBy(array('id' => $id));
                    if (count($blog) > 0) {


                        $em->remove($blog);
                        $em->flush();
                        $dql = "SELECT b.titulo, b.texto, b.id FROM EntityBundle:Blog b ORDER BY b.fecha DESC";

                        $query = $em->createQuery($dql);
                        $result = $query->getResult();

                        return new JsonResponse(array('code' => 200, 'blogs' => $result));
                    }
                    return new JsonResponse($error->dataError($user));
                } catch (\Doctrine\DBAL\Exception $e) {

                    return new JsonResponse($error->dbError($e));
                }
            }
            return new JsonResponse($error->dataError($user));
        }
    }

    public function viewBlogAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $id = $request->query->get('id') ?? false;
            if ($id) {
                $em = $this->getDoctrine()->getManager();
                $dql = "SELECT b.titulo, b.texto, b.id FROM EntityBundle:Blog b WHERE b.id =:id";
                try {
                    $query = $em->createQuery($dql)->setParameter('id', $id);
                    $result = $query->getOneOrNullResult();
                    if (count($result) > 0)
                        return new JsonResponse($result);
                    return new JsonResponse($error->dataError($result));
                } catch (\Doctrine\DBAL\Exception $e) {
                    return new JsonResponse($error->dbError($e));
                }
            }
            return new JsonResponse($error->dataError());
        }
        return new JsonResponse($error->tokenError());
    }

    public function viewsBlogAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $em = $this->getDoctrine()->getManager();
            $dql = "SELECT b.titulo, b.texto, b.id FROM EntityBundle:Blog b ORDER BY b.fecha DESC";
            try {
                $query = $em->createQuery($dql);
                $result = $query->getResult();

                return new JsonResponse(array('code' => 200, 'blogs' => $result));
            } catch (\Doctrine\DBAL\Exception $e) {
                return new JsonResponse($error->dbError($e));
            }
        }
        return new JsonResponse($error->tokenError());
    }

}
