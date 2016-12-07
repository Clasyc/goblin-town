<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zanrai
 *
 * @ORM\Table(name="zanrai")
 * @ORM\Entity
 */
class Zanrai
{
    /**
     * @var string
     *
     * @ORM\Column(name="zanras", type="string", length=50, nullable=false)
     */
    private $zanras;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set zanras
     *
     * @param string $zanras
     *
     * @return Zanrai
     */
    public function setZanras($zanras)
    {
        $this->zanras = $zanras;

        return $this;
    }

    /**
     * Get zanras
     *
     * @return string
     */
    public function getZanras()
    {
        return $this->zanras;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
