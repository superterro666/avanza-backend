<?php

namespace EntityBundle\Entity;

/**
 * BlogImagen
 */
class BlogImagen
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $url;


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
     * Set url
     *
     * @param string $url
     *
     * @return BlogImagen
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * @var \EntityBundle\Entity\Blog
     */
    private $blog;


    /**
     * Set blog
     *
     * @param \EntityBundle\Entity\Blog $blog
     *
     * @return BlogImagen
     */
    public function setBlog(\EntityBundle\Entity\Blog $blog = null)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return \EntityBundle\Entity\Blog
     */
    public function getBlog()
    {
        return $this->blog;
    }
}
