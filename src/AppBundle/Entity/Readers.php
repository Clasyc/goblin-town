<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Readers
 *
 * @ORM\Table(name="readers", indexes={@ORM\Index(name="fkc_reader_to_fosuser", columns={"fk_fosuser"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ReadersRepository")
 */
class Readers
{
    public function __construct()
    {
        $this->penalty = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "Užpildykite šį lauką.",
     *     )
     * @Assert\Length(
     *      max = 40,
     *      maxMessage = "Vardas negali būti ilgesnis nei 40 simbolių"
     *)
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "Užpildykite šį lauką.",
     *     )
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Pavardė negali būti ilgesnis nei 50 simbolių"
     *)
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "Užpildykite šį lauką.",
     *     )
     *  @Assert\Email(
     *     message = "Neteisingas el.pašto formatas",
     *     checkMX = true
     * )
     * @Assert\Length(
     *      max = 180,
     *      maxMessage = "Miesto pavadinimas negali būti ilgesnis nei 180 simbolių"
     *)
     * @ORM\Column(name="email", type="string", length=180, nullable=false)
     */
    private $email;

    /**
     * @var integer
     * @Assert\NotBlank(
     *     message = "Užpildykite telefono laukelį.",
     *     )
     * @Assert\Type(
     *     type="integer",
     *     message="Tefenono numeris privalo būti tokio formato: 86*******."
     * )
     * @Assert\Range(
     *      min = 860000000,
     *      max = 869999999,
     *      minMessage="Tefenono numeris privalo būti tokio formato: 86*******.",
     *      maxMessage="Tefenono numeris privalo būti tokio formato: 86*******."
     *
     *)
     * @ORM\Column(name="phone_number", type="integer", nullable=false)
     */
    private $phoneNumber;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "Užpildykite šį lauką.",
     *     )
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Miestas negali būti ilgesnis nei 50 simbolių"
     *)
     * @ORM\Column(name="city", type="string", length=35, nullable=false)
     */
    private $city;

    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "Užpildykite šį lauką.",
     *     )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Pavardė negali būti ilgesnis nei 255 simboliai"
     *)
     * @ORM\Column(name="adress", type="string", length=255, nullable=false)
     */
    private $adress;

    /**
     * @var integer
     *
     * @ORM\Column(name="personal_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $personalId;

    /**
     * @var \AppBundle\Entity\FosUser
     * @Assert\Valid
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_fosuser", referencedColumnName="id")
     * })
     */
    private $fkFosuser;

    /**
     * @ORM\OneToMany(targetEntity="Penalty", mappedBy="fkReader", cascade={"persist"})
     */
    private $penalty;

    public function hasActivePenalty(){
        if(!empty($this->penalty)){
            $today = new \DateTime();
            foreach($this->penalty as $penalty){
                if($penalty->getPenaltyBeginDate() < $today && $penalty->getPenaltyEndDate() > $today){
                    return true;
                }
            }
        }
        return false;
    }

    public function getActivePenalty(){
        if(!empty($this->penalty)){
            $today = new \DateTime();
            foreach($this->penalty as $penalty){
                if($penalty->getPenaltyBeginDate() < $today && $penalty->getPenaltyEndDate() > $today){
                    return $penalty;
                }
            }
        }
        return false;
    }


    public function setWPenalty($penalty)
    {
        if (!$this->penalty->contains($penalty)) {
            $this->penalty->add($penalty);
        }
        return $this;
    }

    /**
     *  @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPenalty()
    {
        return $this->penalty;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Readers
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Readers
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Readers
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phoneNumber
     *
     * @param integer $phoneNumber
     *
     * @return Readers
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return integer
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Readers
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Readers
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Get personalId
     *
     * @return integer
     */
    public function getPersonalId()
    {
        return $this->personalId;
    }

    /**
     * Set fkFosuser
     *
     * @param \AppBundle\Entity\FosUser $fkFosuser
     *
     * @return Readers
     */
    public function setFkFosuser(\AppBundle\Entity\FosUser $fkFosuser = null)
    {
        $this->fkFosuser = $fkFosuser;

        return $this;
    }

    /**
     * Get fkFosuser
     *
     * @return \AppBundle\Entity\FosUser
     */
    public function getFosuser()
    {
        return $this->fkFosuser;
    }
}
