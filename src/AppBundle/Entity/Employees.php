<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employees
 *
 * @ORM\Table(name="employees", indexes={@ORM\Index(name="fkc_employee_to_fosuser", columns={"fk_fosuser"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\EmployeesRepository")
 */
class Employees
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=40, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=30, nullable=false)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="residence", type="string", length=100, nullable=false)
     */
    private $residence;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=false)
     */
    private $birthDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="works_since", type="date", nullable=false)
     */
    private $worksSince;

    /**
     * @var integer
     *
     * @ORM\Column(name="table_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tableId;

    /**
     * @var \AppBundle\Entity\FosUser
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_fosuser", referencedColumnName="id")
     * })
     */
    private $fkFosuser;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return Employees
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
     * @return Employees
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
     * @return Employees
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
     * @param string $phoneNumber
     *
     * @return Employees
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set residence
     *
     * @param string $residence
     *
     * @return Employees
     */
    public function setResidence($residence)
    {
        $this->residence = $residence;

        return $this;
    }

    /**
     * Get residence
     *
     * @return string
     */
    public function getResidence()
    {
        return $this->residence;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Employees
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set worksSince
     *
     * @param \DateTime $worksSince
     *
     * @return Employees
     */
    public function setWorksSince($worksSince)
    {
        $this->worksSince = $worksSince;

        return $this;
    }

    /**
     * Get worksSince
     *
     * @return \DateTime
     */
    public function getWorksSince()
    {
        return $this->worksSince;
    }

    /**
     * Get tableId
     *
     * @return integer
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * Set fkFosuser
     *
     * @param \AppBundle\Entity\FosUser $fkFosuser
     *
     * @return Employees
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
    public function getFkFosuser()
    {
        return $this->fkFosuser;
    }
}
