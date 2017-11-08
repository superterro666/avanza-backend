<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use EntityBundle\Entity\Portfolio;

class MensajeController extends Controller {

    public function deletePortfolioAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $id = $request->query->get('id') ?? false;
            if ($id) {
                $em = $this->getDoctrine()->getManager();
                try {
                    $portfolio = $em->getRepository("AppBundle:Mensaje")->findOneBy(array('id' => $id));
                    if (count($portfolio) > 0) {


                        $em->remove($portfolio);
                        $em->flush();
                        $dql = "SELECT m.titulo, m.fecha, m.id, m.contenido, m.estado FROM AppBundle:Contacto m  ORDER BY m.fecha DESC";

                        $query = $em->createQuery($dql);
                        $result = $query->getResult();

                        return new JsonResponse(array('code' => 200, 'mensaje' => $result));
                    }
                    return new JsonResponse($error->dataError($user));
                } catch (\Doctrine\DBAL\Exception $e) {

                    return new JsonResponse($error->dbError($e));
                }
            }
            return new JsonResponse($error->dataError($user));
        }
    }

    public function viewMensajeAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $id = $request->query->get('id') ?? false;
            if ($id) {
                $em = $this->getDoctrine()->getManager();
                $dql = "SELECT m.titulo, DATE_FORMAT(m.fecha, '%d-%m-%Y')AS fecha, m.id, m.contenido, m.estado FROM AppBundle:Contacto m  WHERE m.id =:id";
                try {
                    $query = $em->createQuery($dql)->setParameter('id', $id);
                    $result = $query->getOneOrNullResult();
                    if (count($result) > 0)
                        return new JsonResponse(array('code' => 200, 'mensaje' => $result));
                    return new JsonResponse($error->dataError($result));
                } catch (\Doctrine\DBAL\Exception $e) {
                    return new JsonResponse($error->dbError($e));
                }
            }
            return new JsonResponse($error->dataError());
        }
        return new JsonResponse($error->tokenError());
    }

    public function viewsMensajeAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $em = $this->getDoctrine()->getManager();
            $dql = "SELECT m.titulo, DATE_FORMAT(m.fecha, '%d-%m-%Y')AS fecha, m.id, m.contenido, m.estado, m.email, m.telefono FROM AppBundle:Contacto m ORDER BY m.fecha DESC";
            try {
                $query = $em->createQuery($dql);
                $result = $query->getResult();

                return new JsonResponse(array('code' => 200, 'mensajes' => $result));
            } catch (\Doctrine\DBAL\Exception $e) {
                return new JsonResponse($error->dbError($e));
            }
        }
        return new JsonResponse($error->tokenError());
    }

    public function updateMensajeAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $id = $request->query->get('id') ?? false;
            if ($id) {

                try {
                    $em = $this->getDoctrine()->getManager();
                    $mensaje = $em->getRepository('AppBundle:Contacto')->find($id);
                    $mensaje->setEstado(1);
                    $em->persist($mensaje);
                    $em->flush();
                    return new JsonResponse($error->success(1));
                } catch (\Exception $e) {

                    return new JsonResponse($error->dbError($e));
                }
            }

            return new JsonResponse($error->dataError($result));
        }
        return new JsonResponse($error->tokenError());
    }

    public function deleteMensajeAction(Request $request) {
        $error = $this->get('error.service');
        if ($error->parseGet($request)) {
            $id = $request->query->get('id') ?? false;
            if ($id) {

                try {
                    $em = $this->getDoctrine()->getManager();
                    $mensaje = $em->getRepository('AppBundle:Contacto')->find($id);
                    $mensaje->setEstado(1);
                    $em->remove($mensaje);
                    $em->flush();
                    return new JsonResponse($error->success(1));
                } catch (\Exception $e) {

                    return new JsonResponse($error->dbError($e));
                }
            }

            return new JsonResponse($error->dataError($result));
        }
        return new JsonResponse($error->tokenError());
    }

}
