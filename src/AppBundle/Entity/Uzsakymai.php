<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Uzsakymai
 *
 * @ORM\Table(name="uzsakymai", indexes={@ORM\Index(name="fk_knyga_idx", columns={"fk_knyga"}), @ORM\Index(name="fk_darbuotojas_idx", columns={"fk_darbuotojas"}), @ORM\Index(name="fk_skaitytojas_idx", columns={"fk_skaitytojas"})})
 * @ORM\Entity
 */
class Uzsakymai
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="paemimo_data", type="datetime", nullable=false)
     */
    private $paemimoData;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sutarta_grazinimo_data", type="datetime", nullable=false)
     */
    private $sutartaGrazinimoData;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="faktine_grazinimo_data", type="datetime", nullable=false)
     */
    private $faktineGrazinimoData;

    /**
     * @var string
     *
     * @ORM\Column(name="paemimo_salygos", type="string", length=10, nullable=false)
     */
    private $paemimoSalygos;

    /**
     * @var string
     *
     * @ORM\Column(name="busena", type="string", length=20, nullable=false)
     */
    private $busena;

    /**
     * @var string
     *
     * @ORM\Column(name="skolos_tarifas_uz_diena", type="decimal", precision=3, scale=2, nullable=true)
     */
    private $skolosTarifasUzDiena;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var \AppBundle\Entity\Knygos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Knygos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_knyga", referencedColumnName="kodas")
     * })
     */
    private $fkKnyga;

    /**
     * @var \AppBundle\Entity\Darbuotojai
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Darbuotojai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_darbuotojas", referencedColumnName="tabelio_nr")
     * })
     */
    private $fkDarbuotojas;



    /**
     * Set paemimoData
     *
     * @param \DateTime $paemimoData
     *
     * @return Uzsakymai
     */
    public function setPaemimoData($paemimoData)
    {
        $this->paemimoData = $paemimoData;

        return $this;
    }

    /**
     * Get paemimoData
     *
     * @return \DateTime
     */
    public function getPaemimoData()
    {
        return $this->paemimoData;
    }

    /**
     * Set sutartaGrazinimoData
     *
     * @param \DateTime $sutartaGrazinimoData
     *
     * @return Uzsakymai
     */
    public function setSutartaGrazinimoData($sutartaGrazinimoData)
    {
        $this->sutartaGrazinimoData = $sutartaGrazinimoData;

        return $this;
    }

    /**
     * Get sutartaGrazinimoData
     *
     * @return \DateTime
     */
    public function getSutartaGrazinimoData()
    {
        return $this->sutartaGrazinimoData;
    }

    /**
     * Set faktineGrazinimoData
     *
     * @param \DateTime $faktineGrazinimoData
     *
     * @return Uzsakymai
     */
    public function setFaktineGrazinimoData($faktineGrazinimoData)
    {
        $this->faktineGrazinimoData = $faktineGrazinimoData;

        return $this;
    }

    /**
     * Get faktineGrazinimoData
     *
     * @return \DateTime
     */
    public function getFaktineGrazinimoData()
    {
        return $this->faktineGrazinimoData;
    }

    /**
     * Set paemimoSalygos
     *
     * @param string $paemimoSalygos
     *
     * @return Uzsakymai
     */
    public function setPaemimoSalygos($paemimoSalygos)
    {
        $this->paemimoSalygos = $paemimoSalygos;

        return $this;
    }

    /**
     * Get paemimoSalygos
     *
     * @return string
     */
    public function getPaemimoSalygos()
    {
        return $this->paemimoSalygos;
    }

    /**
     * Set busena
     *
     * @param string $busena
     *
     * @return Uzsakymai
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
     * Set skolosTarifasUzDiena
     *
     * @param string $skolosTarifasUzDiena
     *
     * @return Uzsakymai
     */
    public function setSkolosTarifasUzDiena($skolosTarifasUzDiena)
    {
        $this->skolosTarifasUzDiena = $skolosTarifasUzDiena;

        return $this;
    }

    /**
     * Get skolosTarifasUzDiena
     *
     * @return string
     */
    public function getSkolosTarifasUzDiena()
    {
        return $this->skolosTarifasUzDiena;
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
     * Set fkSkaitytojas
     *
     * @param \AppBundle\Entity\Skaitytojai $fkSkaitytojas
     *
     * @return Uzsakymai
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

    /**
     * Set fkKnyga
     *
     * @param \AppBundle\Entity\Knygos $fkKnyga
     *
     * @return Uzsakymai
     */
    public function setFkKnyga(\AppBundle\Entity\Knygos $fkKnyga = null)
    {
        $this->fkKnyga = $fkKnyga;

        return $this;
    }

    /**
     * Get fkKnyga
     *
     * @return \AppBundle\Entity\Knygos
     */
    public function getFkKnyga()
    {
        return $this->fkKnyga;
    }

    /**
     * Set fkDarbuotojas
     *
     * @param \AppBundle\Entity\Darbuotojai $fkDarbuotojas
     *
     * @return Uzsakymai
     */
    public function setFkDarbuotojas(\AppBundle\Entity\Darbuotojai $fkDarbuotojas = null)
    {
        $this->fkDarbuotojas = $fkDarbuotojas;

        return $this;
    }

    /**
     * Get fkDarbuotojas
     *
     * @return \AppBundle\Entity\Darbuotojai
     */
    public function getFkDarbuotojas()
    {
        return $this->fkDarbuotojas;
    }
}
