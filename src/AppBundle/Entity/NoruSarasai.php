<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoruSarasai
 *
 * @ORM\Table(name="noru_sarasai", indexes={@ORM\Index(name="fk_skaitytojas_idx", columns={"fk_skaitytojas"})})
 * @ORM\Entity
 */
class NoruSarasai
{
    /**
     * @var string
     *
     * @ORM\Column(name="pridejimo_data", type="string", length=45, nullable=false)
     */
    private $pridejimoData;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Knygos", inversedBy="fkNoruSarasai")
     * @ORM\JoinTable(name="noru_sarasai_knygos",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_noru_sarasai", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_knyga", referencedColumnName="kodas")
     *   }
     * )
     */
    private $fkKnyga;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkKnyga = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set pridejimoData
     *
     * @param string $pridejimoData
     *
     * @return NoruSarasai
     */
    public function setPridejimoData($pridejimoData)
    {
        $this->pridejimoData = $pridejimoData;

        return $this;
    }

    /**
     * Get pridejimoData
     *
     * @return string
     */
    public function getPridejimoData()
    {
        return $this->pridejimoData;
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
     * @return NoruSarasai
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
     * Add fkKnyga
     *
     * @param \AppBundle\Entity\Knygos $fkKnyga
     *
     * @return NoruSarasai
     */
    public function addFkKnyga(\AppBundle\Entity\Knygos $fkKnyga)
    {
        $this->fkKnyga[] = $fkKnyga;

        return $this;
    }

    /**
     * Remove fkKnyga
     *
     * @param \AppBundle\Entity\Knygos $fkKnyga
     */
    public function removeFkKnyga(\AppBundle\Entity\Knygos $fkKnyga)
    {
        $this->fkKnyga->removeElement($fkKnyga);
    }

    /**
     * Get fkKnyga
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkKnyga()
    {
        return $this->fkKnyga;
    }
}
