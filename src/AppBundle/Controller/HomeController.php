<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Contacto;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class HomeController extends Controller {

    public function avisoAction(){
        return $this->render(':default:avisoLegal.html.twig');
    }

    public function politicaAction(){
        return $this->render(':default:politica.html.twig');
    }

    public function cookiesAction(){
        return $this->render(':default:cookies.html.twig');
    }

    public function indexAction(Request $request){
        $contacto = new Contacto();
        $em = $this->getDoctrine()->getManager();
    
        $form = $this->createFormBuilder($contacto)
            ->add('titulo', TextType::class, array('attr'=>array('class'=>'form-control','minlength'=>3)))
            ->add('email', Emailtype::class, array('attr'=>array('class'=>'form-control','minlength'=>3)))
            ->add('telefono', Texttype::class, array('attr'=>array('class'=>'form-control','minlength'=>9)))
            ->add('servicio', ChoiceType::class, array(
                'choices'  => array(
                    'Software' => 'software',
                    'Imagen y marketing' => 'imagen',
                    'Hardware' => 'hardware',
                    'Redes' => 'redes', 
                    'Soporte tecnico'=>'soporte',
                    'Seguridad y control' => 'seguridad'),
                'attr'=>array('class'=>'form-control')))
            ->add('contenido',TextareaType::class, array('attr'=>array('class'=>'form-control areaForm','minlength'=>3)))  
            ->add('Acepto_la_Politica_de_Privacidad', CheckBoxType::class, array('required'=>true,'attr'=>array('class'=>'form-control politicaForm'),'label_attr'=> array('class'=> 'etiqueta', 'id'=>'etiqueta')))  
            ->add('Enviar', SubmitType::class, array('attr'=>array('class'=>'form-control btForm','minlength'=>3)))
            ->getForm();
    
        $form->remove('fecha'); 
        $form->remove('estado'); 

        
     
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {        
            $contacto = $form->getData();
            $contacto->setFecha(new \Datetime());
            $contacto->setEstado(0);
            $em->persist($contacto);
            $em->flush();
        
        return $this->render(':default:view_contacto.html.twig', array('contacto'=>$contacto));
        
        }
    
        $blogs = $this->getBlogs();
        $portfolios = $this->getPortfolio();
     
     
     
        return $this->render(':default:index.html.twig', array(
            'form' => $form->createView(),
            'principal'=>true,  
            'blogs'=>$blogs, 
            'portfolios'=>$portfolios)
        );
    }
 
 
    private function getBlogs(){
        $em = $this->getDoctrine()->getManager();
        $blogs = $em->getRepository('EntityBundle:Blog')->findAll();
        return $blogs;
    }
 
    private function getPortfolio(){
        $em = $this->getDoctrine()->getManager();
        $portfolio = $em->getRepository('EntityBundle:Portfolio')->findAll();
        return $portfolio;
    }

    // private function getBlogs(Request $request){
    //     $em = $this->getDoctrine()->getManager();
    //     $blogs = $em->getRepository('EntityBundle:Blog')->findAll();
    
    //     $page = $request->query->getInt("page", 1);
    //     $paginator = $this->get("knp_paginator");
    //     $items_per_page = 3;
    
    //     $pagination = $paginator->paginate($blogs, $page, $items_per_page);
    //     $total_items_count = $pagintaion->getTotalItemCount();
        
    
    //     $data = array(
    //         "status" => 'succes',
    //         "total_items_count"=> $total_items_count,
    //         "page_actual" => $page,
    //         "items_per_page" => $items_per_page,
    //         "total_pages" => ceil($total_items_count/$items_per_page),
    //         "data" => $pagination
    //     );
    
    //     return $data;
    // }
 

    
    
  

}
