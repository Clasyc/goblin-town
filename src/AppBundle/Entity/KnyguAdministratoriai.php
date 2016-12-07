<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KnyguAdministratoriai
 *
 * @ORM\Table(name="knygu_administratoriai")
 * @ORM\Entity
 */
class KnyguAdministratoriai
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
     * @ORM\Column(name="el_pastas", type="string", length=50, nullable=false)
     */
    private $elPastas;

    /**
     * @var integer
     *
     * @ORM\Column(name="fk_fosuser", type="integer", nullable=false)
     */
    private $fkFosuser;

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
     * @return KnyguAdministratoriai
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
     * @return KnyguAdministratoriai
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
     * @return KnyguAdministratoriai
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
     * Set fkFosuser
     *
     * @param integer $fkFosuser
     *
     * @return KnyguAdministratoriai
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
