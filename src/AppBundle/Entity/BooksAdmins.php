<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BooksAdmins
 *
 * @ORM\Table(name="books_admins", indexes={@ORM\Index(name="fkc_books_admin_to_fosuser", columns={"fk_fosuser"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BooksAdminRepository")
 */
class BooksAdmins
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=35, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @return BooksAdmins
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
     * @return BooksAdmins
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
     * @return BooksAdmins
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fkFosuser
     *
     * @param \AppBundle\Entity\FosUser $fkFosuser
     *
     * @return BooksAdmins
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
