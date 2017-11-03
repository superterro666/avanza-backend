<?php

namespace EntityBundle\Entity;

/**
 * Blog
 */
class Blog
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $texto;

    /**
     * @var \DateTime
     */
    private $fecha;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Blog
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set texto
     *
     * @param string $texto
     *
     * @return Blog
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Blog
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $blog_imagen;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->blog_imagen = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add blogImagen
     *
     * @param \EntityBundle\Entity\BlogImagen $blogImagen
     *
     * @return Blog
     */
    public function addBlogImagen(\EntityBundle\Entity\BlogImagen $blogImagen)
    {
        $this->blog_imagen[] = $blogImagen;

        return $this;
    }

    /**
     * Remove blogImagen
     *
     * @param \EntityBundle\Entity\BlogImagen $blogImagen
     */
    public function removeBlogImagen(\EntityBundle\Entity\BlogImagen $blogImagen)
    {
        $this->blog_imagen->removeElement($blogImagen);
    }

    /**
     * Get blogImagen
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlogImagen()
    {
        return $this->blog_imagen;
    }
}
