<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skaitytojai
 *
 * @ORM\Table(name="skaitytojai")
 * @ORM\Entity
 */
class Skaitytojai
{
    /**
     * @var string
     *
     * @ORM\Column(name="vardas", type="string", length=40, nullable=false)
     */
    private $vardas;

    /**
     * @var string
     *
     * @ORM\Column(name="pavarde", type="string", length=50, nullable=false)
     */
    private $pavarde;

    /**
     * @var string
     *
     * @ORM\Column(name="el_pastas", type="string", length=255, nullable=false)
     */
    private $elPastas;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefono_nr", type="integer", nullable=false)
     */
    private $telefonoNr;

    /**
     * @var string
     *
     * @ORM\Column(name="miestas", type="string", length=35, nullable=false)
     */
    private $miestas;

    /**
     * @var string
     *
     * @ORM\Column(name="adresas", type="string", length=255, nullable=false)
     */
    private $adresas;

    /**
     * @var integer
     *
     * @ORM\Column(name="asmens_kodas", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $asmensKodas;



    /**
     * Set vardas
     *
     * @param string $vardas
     *
     * @return Skaitytojai
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
     * @return Skaitytojai
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
     * Set elPastas
     *
     * @param string $elPastas
     *
     * @return Skaitytojai
     */
    public function setElPastas($elPastas)
    {
        $this->elPastas = $elPastas;

        return $this;
    }

    /**
     * Get elPastas
     *
     * @return string
     */
    public function getElPastas()
    {
        return $this->elPastas;
    }

    /**
     * Set telefonoNr
     *
     * @param integer $telefonoNr
     *
     * @return Skaitytojai
     */
    public function setTelefonoNr($telefonoNr)
    {
        $this->telefonoNr = $telefonoNr;

        return $this;
    }

    /**
     * Get telefonoNr
     *
     * @return integer
     */
    public function getTelefonoNr()
    {
        return $this->telefonoNr;
    }

    /**
     * Set miestas
     *
     * @param string $miestas
     *
     * @return Skaitytojai
     */
    public function setMiestas($miestas)
    {
        $this->miestas = $miestas;

        return $this;
    }

    /**
     * Get miestas
     *
     * @return string
     */
    public function getMiestas()
    {
        return $this->miestas;
    }

    /**
     * Set adresas
     *
     * @param string $adresas
     *
     * @return Skaitytojai
     */
    public function setAdresas($adresas)
    {
        $this->adresas = $adresas;

        return $this;
    }

    /**
     * Get adresas
     *
     * @return string
     */
    public function getAdresas()
    {
        return $this->adresas;
    }

    /**
     * Get asmensKodas
     *
     * @return integer
     */
    public function getAsmensKodas()
    {
        return $this->asmensKodas;
    }
}
