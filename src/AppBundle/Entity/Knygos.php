<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Knygos
 *
 * @ORM\Table(name="knygos", indexes={@ORM\Index(name="fk_kalba_idx", columns={"fk_kalba"}), @ORM\Index(name="fk_zanras_idx", columns={"fk_zanras"}), @ORM\Index(name="fk_autorius_idx", columns={"fk_autorius"}), @ORM\Index(name="fk_knygu_admin_idx", columns={"fk_knygu_admin"}), @ORM\Index(name="fk_leidykla_idx", columns={"fk_leidykla"})})
 * @ORM\Entity
 */
class Knygos
{
    /**
     * @var string
     *
     * @ORM\Column(name="isbn_kodas", type="string", length=13, nullable=false)
     */
    private $isbnKodas;

    /**
     * @var string
     *
     * @ORM\Column(name="pavadinimas", type="string", length=255, nullable=false)
     */
    private $pavadinimas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="metai", type="date", nullable=false)
     */
    private $metai;

    /**
     * @var integer
     *
     * @ORM\Column(name="puslapiai", type="integer", nullable=false)
     */
    private $puslapiai;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ar_uzsakyta", type="boolean", nullable=true)
     */
    private $arUzsakyta;

    /**
     * @var integer
     *
     * @ORM\Column(name="kodas", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $kodas;

    /**
     * @var \AppBundle\Entity\Zanrai
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Zanrai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_zanras", referencedColumnName="id")
     * })
     */
    private $fkZanras;

    /**
     * @var \AppBundle\Entity\Leidyklos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Leidyklos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_leidykla", referencedColumnName="id")
     * })
     */
    private $fkLeidykla;

    /**
     * @var \AppBundle\Entity\KnyguAdministratoriai
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\KnyguAdministratoriai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_knygu_admin", referencedColumnName="id")
     * })
     */
    private $fkKnyguAdmin;

    /**
     * @var \AppBundle\Entity\Autoriai
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Autoriai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_autorius", referencedColumnName="id")
     * })
     */
    private $fkAutorius;

    /**
     * @var \AppBundle\Entity\Kalbos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kalbos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_kalba", referencedColumnName="id")
     * })
     */
    private $fkKalba;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\NoruSarasai", mappedBy="fkKnyga")
     */
    private $fkNoruSarasai;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkNoruSarasai = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set isbnKodas
     *
     * @param string $isbnKodas
     *
     * @return Knygos
     */
    public function setIsbnKodas($isbnKodas)
    {
        $this->isbnKodas = $isbnKodas;

        return $this;
    }

    /**
     * Get isbnKodas
     *
     * @return string
     */
    public function getIsbnKodas()
    {
        return $this->isbnKodas;
    }

    /**
     * Set pavadinimas
     *
     * @param string $pavadinimas
     *
     * @return Knygos
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
     * Set metai
     *
     * @param \DateTime $metai
     *
     * @return Knygos
     */
    public function setMetai($metai)
    {
        $this->metai = $metai;

        return $this;
    }

    /**
     * Get metai
     *
     * @return \DateTime
     */
    public function getMetai()
    {
        return $this->metai;
    }

    /**
     * Set puslapiai
     *
     * @param integer $puslapiai
     *
     * @return Knygos
     */
    public function setPuslapiai($puslapiai)
    {
        $this->puslapiai = $puslapiai;

        return $this;
    }

    /**
     * Get puslapiai
     *
     * @return integer
     */
    public function getPuslapiai()
    {
        return $this->puslapiai;
    }

    /**
     * Set arUzsakyta
     *
     * @param boolean $arUzsakyta
     *
     * @return Knygos
     */
    public function setArUzsakyta($arUzsakyta)
    {
        $this->arUzsakyta = $arUzsakyta;

        return $this;
    }

    /**
     * Get arUzsakyta
     *
     * @return boolean
     */
    public function getArUzsakyta()
    {
        return $this->arUzsakyta;
    }

    /**
     * Get kodas
     *
     * @return integer
     */
    public function getKodas()
    {
        return $this->kodas;
    }

    /**
     * Set fkZanras
     *
     * @param \AppBundle\Entity\Zanrai $fkZanras
     *
     * @return Knygos
     */
    public function setFkZanras(\AppBundle\Entity\Zanrai $fkZanras = null)
    {
        $this->fkZanras = $fkZanras;

        return $this;
    }

    /**
     * Get fkZanras
     *
     * @return \AppBundle\Entity\Zanrai
     */
    public function getFkZanras()
    {
        return $this->fkZanras;
    }

    /**
     * Set fkLeidykla
     *
     * @param \AppBundle\Entity\Leidyklos $fkLeidykla
     *
     * @return Knygos
     */
    public function setFkLeidykla(\AppBundle\Entity\Leidyklos $fkLeidykla = null)
    {
        $this->fkLeidykla = $fkLeidykla;

        return $this;
    }

    /**
     * Get fkLeidykla
     *
     * @return \AppBundle\Entity\Leidyklos
     */
    public function getFkLeidykla()
    {
        return $this->fkLeidykla;
    }

    /**
     * Set fkKnyguAdmin
     *
     * @param \AppBundle\Entity\KnyguAdministratoriai $fkKnyguAdmin
     *
     * @return Knygos
     */
    public function setFkKnyguAdmin(\AppBundle\Entity\KnyguAdministratoriai $fkKnyguAdmin = null)
    {
        $this->fkKnyguAdmin = $fkKnyguAdmin;

        return $this;
    }

    /**
     * Get fkKnyguAdmin
     *
     * @return \AppBundle\Entity\KnyguAdministratoriai
     */
    public function getFkKnyguAdmin()
    {
        return $this->fkKnyguAdmin;
    }

    /**
     * Set fkAutorius
     *
     * @param \AppBundle\Entity\Autoriai $fkAutorius
     *
     * @return Knygos
     */
    public function setFkAutorius(\AppBundle\Entity\Autoriai $fkAutorius = null)
    {
        $this->fkAutorius = $fkAutorius;

        return $this;
    }

    /**
     * Get fkAutorius
     *
     * @return \AppBundle\Entity\Autoriai
     */
    public function getFkAutorius()
    {
        return $this->fkAutorius;
    }

    /**
     * Set fkKalba
     *
     * @param \AppBundle\Entity\Kalbos $fkKalba
     *
     * @return Knygos
     */
    public function setFkKalba(\AppBundle\Entity\Kalbos $fkKalba = null)
    {
        $this->fkKalba = $fkKalba;

        return $this;
    }

    /**
     * Get fkKalba
     *
     * @return \AppBundle\Entity\Kalbos
     */
    public function getFkKalba()
    {
        return $this->fkKalba;
    }

    /**
     * Add fkNoruSarasai
     *
     * @param \AppBundle\Entity\NoruSarasai $fkNoruSarasai
     *
     * @return Knygos
     */
    public function addFkNoruSarasai(\AppBundle\Entity\NoruSarasai $fkNoruSarasai)
    {
        $this->fkNoruSarasai[] = $fkNoruSarasai;

        return $this;
    }

    /**
     * Remove fkNoruSarasai
     *
     * @param \AppBundle\Entity\NoruSarasai $fkNoruSarasai
     */
    public function removeFkNoruSarasai(\AppBundle\Entity\NoruSarasai $fkNoruSarasai)
    {
        $this->fkNoruSarasai->removeElement($fkNoruSarasai);
    }

    /**
     * Get fkNoruSarasai
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkNoruSarasai()
    {
        return $this->fkNoruSarasai;
    }
}
