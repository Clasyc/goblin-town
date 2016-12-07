<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Darbuotojai
 *
 * @ORM\Table(name="darbuotojai")
 * @ORM\Entity
 */
class Darbuotojai
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
     * @ORM\Column(name="pavarde", type="string", length=40, nullable=false)
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
     * @ORM\Column(name="gyvenamoji_vieta", type="string", length=100, nullable=false)
     */
    private $gyvenamojiVieta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="gimimo_data", type="date", nullable=true)
     */
    private $gimimoData;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dirba_nuo", type="date", nullable=true)
     */
    private $dirbaNuo;

    /**
     * @var integer
     *
     * @ORM\Column(name="fk_fosuser", type="integer", nullable=true)
     */
    private $fkFosuser;

    /**
     * @var integer
     *
     * @ORM\Column(name="tabelio_nr", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tabelioNr;



    /**
     * Set vardas
     *
     * @param string $vardas
     *
     * @return Darbuotojai
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
     * @return Darbuotojai
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
     * @return Darbuotojai
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
     * @return Darbuotojai
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
     * Set gyvenamojiVieta
     *
     * @param string $gyvenamojiVieta
     *
     * @return Darbuotojai
     */
    public function setGyvenamojiVieta($gyvenamojiVieta)
    {
        $this->gyvenamojiVieta = $gyvenamojiVieta;

        return $this;
    }

    /**
     * Get gyvenamojiVieta
     *
     * @return string
     */
    public function getGyvenamojiVieta()
    {
        return $this->gyvenamojiVieta;
    }

    /**
     * Set gimimoData
     *
     * @param \DateTime $gimimoData
     *
     * @return Darbuotojai
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
     * Set dirbaNuo
     *
     * @param \DateTime $dirbaNuo
     *
     * @return Darbuotojai
     */
    public function setDirbaNuo($dirbaNuo)
    {
        $this->dirbaNuo = $dirbaNuo;

        return $this;
    }

    /**
     * Get dirbaNuo
     *
     * @return \DateTime
     */
    public function getDirbaNuo()
    {
        return $this->dirbaNuo;
    }

    /**
     * Set fkFosuser
     *
     * @param integer $fkFosuser
     *
     * @return Darbuotojai
     */
    public function setFkFosuser($fkFosuser)
    {
        $this->fkFosuser = $fkFosuser;

        return $this;
    }

    /**
     * Get fkFosuser
     *
     * @return integer
     */
    public function getFkFosuser()
    {
        return $this->fkFosuser;
    }

    /**
     * Get tabelioNr
     *
     * @return integer
     */
    public function getTabelioNr()
    {
        return $this->tabelioNr;
    }
}
