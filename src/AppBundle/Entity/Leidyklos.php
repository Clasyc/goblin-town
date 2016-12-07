<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Leidyklos
 *
 * @ORM\Table(name="leidyklos")
 * @ORM\Entity
 */
class Leidyklos
{
    /**
     * @var string
     *
     * @ORM\Column(name="pavadinimas", type="string", length=255, nullable=false)
     */
    private $pavadinimas;

    /**
     * @var string
     *
     * @ORM\Column(name="adresas", type="string", length=255, nullable=false)
     */
    private $adresas;

    /**
     * @var string
     *
     * @ORM\Column(name="miestas", type="string", length=50, nullable=false)
     */
    private $miestas;

    /**
     * @var string
     *
     * @ORM\Column(name="pasto_kodas", type="string", length=20, nullable=false)
     */
    private $pastoKodas;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_nr", type="string", length=20, nullable=false)
     */
    private $telefonoNr;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set pavadinimas
     *
     * @param string $pavadinimas
     *
     * @return Leidyklos
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
     * Set adresas
     *
     * @param string $adresas
     *
     * @return Leidyklos
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
     * Set miestas
     *
     * @param string $miestas
     *
     * @return Leidyklos
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
     * Set pastoKodas
     *
     * @param string $pastoKodas
     *
     * @return Leidyklos
     */
    public function setPastoKodas($pastoKodas)
    {
        $this->pastoKodas = $pastoKodas;

        return $this;
    }

    /**
     * Get pastoKodas
     *
     * @return string
     */
    public function getPastoKodas()
    {
        return $this->pastoKodas;
    }

    /**
     * Set telefonoNr
     *
     * @param string $telefonoNr
     *
     * @return Leidyklos
     */
    public function setTelefonoNr($telefonoNr)
    {
        $this->telefonoNr = $telefonoNr;

        return $this;
    }

    /**
     * Get telefonoNr
     *
     * @return string
     */
    public function getTelefonoNr()
    {
        return $this->telefonoNr;
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
