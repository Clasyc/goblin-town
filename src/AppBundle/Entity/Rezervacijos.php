<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rezervacijos
 *
 * @ORM\Table(name="rezervacijos", indexes={@ORM\Index(name="fk_skaitytojas_idx", columns={"fk_skaitytojas"}), @ORM\Index(name="fk_knyga_idx", columns={"fk_knyga"})})
 * @ORM\Entity
 */
class Rezervacijos
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;

    /**
     * @var integer
     *
     * @ORM\Column(name="vieta_eileje", type="integer", nullable=true)
     */
    private $vietaEileje;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pajudejo_eile_data", type="datetime", nullable=true)
     */
    private $pajudejoEileData;

    /**
     * @var string
     *
     * @ORM\Column(name="busena", type="string", length=20, nullable=true)
     */
    private $busena;

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
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Rezervacijos
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set vietaEileje
     *
     * @param integer $vietaEileje
     *
     * @return Rezervacijos
     */
    public function setVietaEileje($vietaEileje)
    {
        $this->vietaEileje = $vietaEileje;

        return $this;
    }

    /**
     * Get vietaEileje
     *
     * @return integer
     */
    public function getVietaEileje()
    {
        return $this->vietaEileje;
    }

    /**
     * Set pajudejoEileData
     *
     * @param \DateTime $pajudejoEileData
     *
     * @return Rezervacijos
     */
    public function setPajudejoEileData($pajudejoEileData)
    {
        $this->pajudejoEileData = $pajudejoEileData;

        return $this;
    }

    /**
     * Get pajudejoEileData
     *
     * @return \DateTime
     */
    public function getPajudejoEileData()
    {
        return $this->pajudejoEileData;
    }

    /**
     * Set busena
     *
     * @param string $busena
     *
     * @return Rezervacijos
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
     * @return Rezervacijos
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
     * @return Rezervacijos
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
}
