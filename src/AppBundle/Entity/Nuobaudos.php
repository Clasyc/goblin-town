<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nuobaudos
 *
 * @ORM\Table(name="nuobaudos", indexes={@ORM\Index(name="fk_skaitytoju_admin_idx", columns={"fk_skaitytoju_admin"}), @ORM\Index(name="fk_skaitytojas_idx", columns={"fk_skaitytojas"})})
 * @ORM\Entity
 */
class Nuobaudos
{
    /**
     * @var string
     *
     * @ORM\Column(name="pavadinimas", type="string", length=50, nullable=false)
     */
    private $pavadinimas;

    /**
     * @var string
     *
     * @ORM\Column(name="komentaras", type="string", length=255, nullable=true)
     */
    private $komentaras;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="nuobaudos_pradzia", type="date", nullable=true)
     */
    private $nuobaudosPradzia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="nuobaudos_pabaiga", type="date", nullable=true)
     */
    private $nuobaudosPabaiga;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\SkaitytojuAdministratorius
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SkaitytojuAdministratorius")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_skaitytoju_admin", referencedColumnName="id")
     * })
     */
    private $fkSkaitytojuAdmin;

    /**
     * @var \AppBundle\Entity\Skaitytojai
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Skaitytojai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_skaitytojas", referencedColumnName="asmens_kodas")
     * })
     */
    private $fkSkaitytojas;



    /**
     * Set pavadinimas
     *
     * @param string $pavadinimas
     *
     * @return Nuobaudos
     */
    public function setPavadinimas($pavadinimas)
    {
        $this->pavadinimas = $pavadinimas;

        return $this;
    }

    /**
     * Get pavadinimas
     *
     * @return string
     */
    public function getPavadinimas()
    {
        return $this->pavadinimas;
    }

    /**
     * Set komentaras
     *
     * @param string $komentaras
     *
     * @return Nuobaudos
     */
    public function setKomentaras($komentaras)
    {
        $this->komentaras = $komentaras;

        return $this;
    }

    /**
     * Get komentaras
     *
     * @return string
     */
    public function getKomentaras()
    {
        return $this->komentaras;
    }

    /**
     * Set nuobaudosPradzia
     *
     * @param \DateTime $nuobaudosPradzia
     *
     * @return Nuobaudos
     */
    public function setNuobaudosPradzia($nuobaudosPradzia)
    {
        $this->nuobaudosPradzia = $nuobaudosPradzia;

        return $this;
    }

    /**
     * Get nuobaudosPradzia
     *
     * @return \DateTime
     */
    public function getNuobaudosPradzia()
    {
        return $this->nuobaudosPradzia;
    }

    /**
     * Set nuobaudosPabaiga
     *
     * @param \DateTime $nuobaudosPabaiga
     *
     * @return Nuobaudos
     */
    public function setNuobaudosPabaiga($nuobaudosPabaiga)
    {
        $this->nuobaudosPabaiga = $nuobaudosPabaiga;

        return $this;
    }

    /**
     * Get nuobaudosPabaiga
     *
     * @return \DateTime
     */
    public function getNuobaudosPabaiga()
    {
        return $this->nuobaudosPabaiga;
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

    /**
     * Set fkSkaitytojuAdmin
     *
     * @param \AppBundle\Entity\SkaitytojuAdministratorius $fkSkaitytojuAdmin
     *
     * @return Nuobaudos
     */
    public function setFkSkaitytojuAdmin(\AppBundle\Entity\SkaitytojuAdministratorius $fkSkaitytojuAdmin = null)
    {
        $this->fkSkaitytojuAdmin = $fkSkaitytojuAdmin;

        return $this;
    }

    /**
     * Get fkSkaitytojuAdmin
     *
     * @return \AppBundle\Entity\SkaitytojuAdministratorius
     */
    public function getFkSkaitytojuAdmin()
    {
        return $this->fkSkaitytojuAdmin;
    }

    /**
     * Set fkSkaitytojas
     *
     * @param \AppBundle\Entity\Skaitytojai $fkSkaitytojas
     *
     * @return Nuobaudos
     */
    public function setFkSkaitytojas(\AppBundle\Entity\Skaitytojai $fkSkaitytojas = null)
    {
        $this->fkSkaitytojas = $fkSkaitytojas;

        return $this;
    }

    /**
     * Get fkSkaitytojas
     *
     * @return \AppBundle\Entity\Skaitytojai
     */
    public function getFkSkaitytojas()
    {
        return $this->fkSkaitytojas;
    }
}
