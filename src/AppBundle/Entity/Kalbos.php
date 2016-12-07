<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kalbos
 *
 * @ORM\Table(name="kalbos")
 * @ORM\Entity
 */
class Kalbos
{
    /**
     * @var string
     *
     * @ORM\Column(name="kalba", type="string", length=50, nullable=false)
     */
    private $kalba;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set kalba
     *
     * @param string $kalba
     *
     * @return Kalbos
     */
    public function setKalba($kalba)
    {
        $this->kalba = $kalba;

        return $this;
    }

    /**
     * Get kalba
     *
     * @return string
     */
    public function getKalba()
    {
        return $this->kalba;
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
