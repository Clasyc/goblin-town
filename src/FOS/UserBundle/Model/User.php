<?php

namespace FOS\UserBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\MappedSuperclass
 */
class User
{
    /**
     * @var string
     * @Assert\NotBlank(
     *     message = "Užpildykite prisijungimo vardo laukelį.",
     *     )
     * @Assert\Length(
     *      min = 0,
     *      max = 180,
     *      minMessage = "Prisijungimo vardas negali būti tuščias",
     *      maxMessage = "Prisijungimo vardas negali būti ilgesnis nei 180 simboliai."
     *)
     * @ORM\Column(name="username", type="string", length=180)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="username_canonical", type="string", length=180, unique=true)
     */
    private $usernameCanonical;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$",
     *     match=false,
     *     message="Your name cannot contain a number"
     * )
     * @Assert\Length(
     *      min = 0,
     *      max = 180,
     *      minMessage = "El.paštas negali būti tuščias",
     *      maxMessage = "El.paštas negali būti ilgesnis nei 180 simboliai."
     *)
     * @ORM\Column(name="email", type="string", length=180)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="email_canonical", type="string", length=180, unique=true)
     */
    private $emailCanonical;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string")
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean")
     */
    private $locked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="expired", type="boolean")
     */
    private $expired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=true)
     */
    private $expiresAt;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string", length=180, nullable=true, unique=true)
     */
    private $confirmationToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    private $passwordRequestedAt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var boolean
     *
     * @ORM\Column(name="credentials_expired", type="boolean")
     */
    private $credentialsExpired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="credentials_expire_at", type="datetime", nullable=true)
     */
    private $credentialsExpireAt;

    /**
     * @Assert\Length(
     *     min=6,
     *     max=4096,
     *     minMessage="Slaptažodis privalo būti sudarytas bent iš 6 simbolių",
     * )
     */
    private $plainPassword;


}

