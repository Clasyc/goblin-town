<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkaitytojuAdministratorius
 *
 * @ORM\Table(name="skaitytoju_administratorius")
 * @ORM\Entity
 */
class SkaitytojuAdministratorius
{
    /**
     * @var string
     *
     * @ORM\Column(name="vardas", type="string", length=40, nullable=true)
     */
    private $vardas;

    /**
     * @var string
     *
     * @ORM\Column(name="pavarde", type="string", length=50, nullable=true)
     */
    private $pavarde;

    /**
     * @var string
     *
     * @ORM\Column(name="el_pastas", type="string", length=255, nullable=true)
     */
    private $elPastas;

    /**
     * @var integer
     *
     * @ORM\Column(name="fk_fosuser", type="integer", nullable=true)
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
     * @return SkaitytojuAdministratorius
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
     * @return SkaitytojuAdministratorius
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
     * @return SkaitytojuAdministratorius
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
     * @return SkaitytojuAdministratorius
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
