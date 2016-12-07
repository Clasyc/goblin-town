<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Autoriai
 *
 * @ORM\Table(name="autoriai")
 * @ORM\Entity
 */
class Autoriai
{
    /**
     * @var string
     *
     * @ORM\Column(name="vardas", type="string", length=30, nullable=false)
     */
    private $vardas;

    /**
     * @var string
     *
     * @ORM\Column(name="pavarde", type="string", length=30, nullable=false)
     */
    private $pavarde;

    /**
     * @var string
     *
     * @ORM\Column(name="tautybe", type="string", length=20, nullable=false)
     */
    private $tautybe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="gimimo_data", type="date", nullable=false)
     */
    private $gimimoData;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mirties_data", type="date", nullable=true)
     */
    private $mirtiesData;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set vardas
     *
     * @param string $vardas
     *
     * @return Autoriai
     */
    public function setVardas($vardas)
    {
        $this->vardas = $vardas;

        return $this;
    }

    /**
     * Get vardas
     *
     * @return string
     */
    public function getVardas()
    {
        return $this->vardas;
    }

    /**
     * Set pavarde
     *
     * @param string $pavarde
     *
     * @return Autoriai
     */
    public function setPavarde($pavarde)
    {
        $this->pavarde = $pavarde;

        return $this;
    }

    /**
     * Get pavarde
     *
     * @return string
     */
    public function getPavarde()
    {
        return $this->pavarde;
    }

    /**
     * Set tautybe
     *
     * @param string $tautybe
     *
     * @return Autoriai
     */
    public function setTautybe($tautybe)
    {
        $this->tautybe = $tautybe;

        return $this;
    }

    /**
     * Get tautybe
     *
     * @return string
     */
    public function getTautybe()
    {
        return $this->tautybe;
    }

    /**
     * Set gimimoData
     *
     * @param \DateTime $gimimoData
     *
     * @return Autoriai
     */
    public function setGimimoData($gimimoData)
    {
        $this->gimimoData = $gimimoData;

        return $this;
    }

    /**
     * Get gimimoData
     *
     * @return \DateTime
     */
    public function getGimimoData()
    {
        return $this->gimimoData;
    }

    /**
     * Set mirtiesData
     *
     * @param \DateTime $mirtiesData
     *
     * @return Autoriai
     */
    public function setMirtiesData($mirtiesData)
    {
        $this->mirtiesData = $mirtiesData;

        return $this;
    }

    /**
     * Get mirtiesData
     *
     * @return \DateTime
     */
    public function getMirtiesData()
    {
        return $this->mirtiesData;
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
