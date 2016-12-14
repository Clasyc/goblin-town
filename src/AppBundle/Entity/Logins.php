<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Logins
 *
 * @ORM\Table(name="logins")
 * @ORM\Entity
 */
class Logins
{
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=32, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=30, nullable=false)
     */
    private $role;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="date", nullable=false)
     */
    private $registrationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="login_name", type="string", length=50)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $loginName;



    /**
     * Set password
     *
     * @param string $password
     *
     * @return Logins
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Logins
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return Logins
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Get loginName
     *
     * @return string
     */
    public function getLoginName()
    {
        return $this->loginName;
    }
}
