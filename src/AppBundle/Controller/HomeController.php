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

class HomeController extends Controller {

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
             'Seguridad y control' => 'seguridad'    
    ),'attr'=>array('class'=>'form-control')))
        ->add('contenido',TextareaType::class, array('attr'=>array('class'=>'form-control','minlength'=>3)))    
        ->add('save', SubmitType::class, array('attr'=>array('class'=>'form-control','minlength'=>3,'label' => 'Enviar')))
        ->getForm();
    
    
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        
        $contacto = $form->getData();
        $em->persist($contacto);
        $em->flush();
        
         return $this->render(':default:view_contacto.html.twig', array('contacto'=>$contacto));
        
   }
     $blogs = $this->getBlogs();
     $portfolios = $this->getPortfolio();
     
     return $this->render(':default:index.html.twig', array(
       'form' => $form->createView(),'principal'=>true, 'blogs'=>$blogs, 'portfolios'=>$portfolios));
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
 

    
    
  

}
