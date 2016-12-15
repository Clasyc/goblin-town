<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Penalty
 *
 * @ORM\Table(name="penalty", indexes={@ORM\Index(name="fkc_penalty_to_readers_admin_idx", columns={"fk_readers_admin"}), @ORM\Index(name="fkc_penalty_to_reader_idx", columns={"fk_reader"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PenaltyRepository")
 */
class Penalty
{
    /**
     * @var string
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Pavadinimas negali būti ilgesnis nei 50 simbolių"
     * )
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Komentaras negali būti ilgesnis nei 255 simbolių"
     * )
     * @ORM\Column(name="comment", type="string", length=255, nullable=false)
     */
    private $comment;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @ORM\Column(name="penalty_begin_date", type="datetime", nullable=false)
     */
    private $penaltyBeginDate;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @Assert\GreaterThan("today")
     * @ORM\Column(name="penalty_end_date", type="datetime", nullable=false)
     */
    private $penaltyEndDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\ReadersAdmin
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ReadersAdmin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_readers_admin", referencedColumnName="id")
     * })
     */
    private $fkReadersAdmin;

    /**
     * @var \AppBundle\Entity\Readers
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Readers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_reader", referencedColumnName="personal_id")
     * })
     */
    private $fkReader;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return Penalty
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Penalty
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set penaltyBeginDate
     *
     * @param \DateTime $penaltyBeginDate
     *
     * @return Penalty
     */
    public function setPenaltyBeginDate($penaltyBeginDate)
    {
        $this->penaltyBeginDate = $penaltyBeginDate;

        return $this;
    }

    /**
     * Get penaltyBeginDate
     *
     * @return \DateTime
     */
    public function getPenaltyBeginDate()
    {
        return $this->penaltyBeginDate;
    }

    /**
     * Set penaltyEndDate
     *
     * @param \DateTime $penaltyEndDate
     *
     * @return Penalty
     */
    public function setPenaltyEndDate($penaltyEndDate)
    {
        $this->penaltyEndDate = $penaltyEndDate;

        return $this;
    }

    /**
     * Get penaltyEndDate
     *
     * @return \DateTime
     */
    public function getPenaltyEndDate()
    {
        return $this->penaltyEndDate;
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
     * Set fkReadersAdmin
     *
     * @param \AppBundle\Entity\ReadersAdmin $fkReadersAdmin
     *
     * @return Penalty
     */
    public function setFkReadersAdmin(\AppBundle\Entity\ReadersAdmin $fkReadersAdmin = null)
    {
        $this->fkReadersAdmin = $fkReadersAdmin;

        return $this;
    }

    /**
     * Get fkReadersAdmin
     *
     * @return \AppBundle\Entity\ReadersAdmin
     */
    public function getFkReadersAdmin()
    {
        return $this->fkReadersAdmin;
    }

    /**
     * Set fkReader
     *
     * @param \AppBundle\Entity\Readers $fkReader
     *
     * @return Penalty
     */
    public function setFkReader(\AppBundle\Entity\Readers $fkReader = null)
    {
        $this->fkReader = $fkReader;

        return $this;
    }

    /**
     * Get fkReader
     *
     * @return \AppBundle\Entity\Readers
     */
    public function getFkReader()
    {
        return $this->fkReader;
    }
}
