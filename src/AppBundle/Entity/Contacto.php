<?php

namespace AppBundle\Entity;

/**
 * Contacto
 */
class Contacto
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
    private $email;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $contenido;

    /**
     * @var string
     */
    private $servicio;


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
     * @return Contacto
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
     * Set email
     *
     * @param string $email
     *
     * @return Contacto
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Contacto
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return Contacto
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set servicio
     *
     * @param string $servicio
     *
     * @return Contacto
     */
    public function setServicio($servicio)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return string
     */
    public function getServicio()
    {
        return $this->servicio;
    }
    /**
     * @var boolean
     */
    private $estado;

    /**
     * @var \DateTime
     */
    private $fecha;


    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Contacto
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Contacto
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
     * @var boolean
     */
    private $Acepto_la_Politica_de_Privacidad;


    /**
     * Set aceptoLaPoliticaDePrivacidad
     *
     * @param boolean $aceptoLaPoliticaDePrivacidad
     *
     * @return Contacto
     */
    public function setAceptoLaPoliticaDePrivacidad($aceptoLaPoliticaDePrivacidad)
    {
        $this->Acepto_la_Politica_de_Privacidad = $aceptoLaPoliticaDePrivacidad;

        return $this;
    }

    /**
     * Get aceptoLaPoliticaDePrivacidad
     *
     * @return boolean
     */
    public function getAceptoLaPoliticaDePrivacidad()
    {
        return $this->Acepto_la_Politica_de_Privacidad;
    }
}
