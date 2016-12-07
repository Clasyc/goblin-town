<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skolos
 *
 * @ORM\Table(name="skolos")
 * @ORM\Entity
 */
class Skolos
{
    /**
     * @var string
     *
     * @ORM\Column(name="busena", type="string", length=20, nullable=true)
     */
    private $busena;

    /**
     * @var string
     *
     * @ORM\Column(name="suma", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $suma;

    /**
     * @var string
     *
     * @ORM\Column(name="aprasymas", type="string", length=100, nullable=true)
     */
    private $aprasymas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="apmokejimo_data", type="date", nullable=true)
     */
    private $apmokejimoData;

    /**
     * @var integer
     *
     * @ORM\Column(name="fk_uzsakymas", type="integer", nullable=true)
     */
    private $fkUzsakymas;

    /**
     * @var \AppBundle\Entity\Uzsakymai
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Uzsakymai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;



    /**
     * Set busena
     *
     * @param string $busena
     *
     * @return Skolos
     */
    public function setBusena($busena)
    {
        $this->busena = $busena;

        return $this;
    }

    /**
     * Get busena
     *
     * @return string
     */
    public function getBusena()
    {
        return $this->busena;
    }

    /**
     * Set suma
     *
     * @param string $suma
     *
     * @return Skolos
     */
    public function setSuma($suma)
    {
        $this->suma = $suma;

        return $this;
    }

    /**
     * Get suma
     *
     * @return string
     */
    public function getSuma()
    {
        return $this->suma;
    }

    /**
     * Set aprasymas
     *
     * @param string $aprasymas
     *
     * @return Skolos
     */
    public function setAprasymas($aprasymas)
    {
        $this->aprasymas = $aprasymas;

        return $this;
    }

    /**
     * Get aprasymas
     *
     * @return string
     */
    public function getAprasymas()
    {
        return $this->aprasymas;
    }

    /**
     * Set apmokejimoData
     *
     * @param \DateTime $apmokejimoData
     *
     * @return Skolos
     */
    public function setApmokejimoData($apmokejimoData)
    {
        $this->apmokejimoData = $apmokejimoData;

        return $this;
    }

    /**
     * Get apmokejimoData
     *
     * @return \DateTime
     */
    public function getApmokejimoData()
    {
        return $this->apmokejimoData;
    }

    /**
     * Set fkUzsakymas
     *
     * @param integer $fkUzsakymas
     *
     * @return Skolos
     */
    public function setFkUzsakymas($fkUzsakymas)
    {
        $this->fkUzsakymas = $fkUzsakymas;

        return $this;
    }

    /**
     * Get fkUzsakymas
     *
     * @return integer
     */
    public function getFkUzsakymas()
    {
        return $this->fkUzsakymas;
    }

    /**
     * Set id
     *
     * @param \AppBundle\Entity\Uzsakymai $id
     *
     * @return Skolos
     */
    public function setId(\AppBundle\Entity\Uzsakymai $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return \AppBundle\Entity\Uzsakymai
     */
    public function getId()
    {
        return $this->id;
    }
}
