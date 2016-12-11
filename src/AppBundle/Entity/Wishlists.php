<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlists
 *
 * @ORM\Table(name="wishlists", indexes={@ORM\Index(name="fkc_wishlist_to_reader_idx", columns={"fk_reader"}), @ORM\Index(name="fkc_wishlist_to_book_idx", columns={"fk_book"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\WishlistRepository")
 */
class Wishlists
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addition_date", type="datetime", nullable=false)
     */
    private $additionDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * @var \AppBundle\Entity\Books
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Books")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_book", referencedColumnName="id")
     * })
     */
    private $fkBook;



    /**
     * Set additionDate
     *
     * @param \DateTime $additionDate
     *
     * @return Wishlists
     */
    public function setAdditionDate($additionDate)
    {
        $this->additionDate = $additionDate;

        return $this;
    }

    /**
     * Get additionDate
     *
     * @return \DateTime
     */
    public function getAdditionDate()
    {
        return $this->additionDate;
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
     * Set fkReader
     *
     * @param \AppBundle\Entity\Readers $fkReader
     *
     * @return Wishlists
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

    /**
     * Set fkBook
     *
     * @param \AppBundle\Entity\Books $fkBook
     *
     * @return Wishlists
     */
    public function setFkBook(\AppBundle\Entity\Books $fkBook = null)
    {
        $this->fkBook = $fkBook;

        return $this;
    }

    /**
     * Get fkBook
     *
     * @return \AppBundle\Entity\Books
     */
    public function getFkBook()
    {
        return $this->fkBook;
    }
}
