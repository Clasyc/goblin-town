<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Books
 *
 * @ORM\Table(name="books", indexes={@ORM\Index(name="fkc_book_to_language_idx", columns={"fk_language"}), @ORM\Index(name="fkc_book_to_genre_idx", columns={"fk_genre"}), @ORM\Index(name="fkc_author_idx", columns={"fk_author"}), @ORM\Index(name="fkc_book_to_books_admin_idx", columns={"fk_books_admin"}), @ORM\Index(name="fkc_book_to_publisher_idx", columns={"fk_publisher"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BooksRepository")
 */
class Books
{

    public function __construct()
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="isbn_code", type="string", length=13, nullable=false)
     */
    private $isbnCode;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="year", type="date", nullable=false)
     */
    private $year;

    /**
     * @var integer
     *
     * @ORM\Column(name="page_count", type="integer", nullable=false)
     */
    private $pageCount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ordered", type="boolean", nullable=false)
     */
    private $ordered;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Publishers
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Publishers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_publisher", referencedColumnName="id")
     * })
     */
    private $fkPublisher;

    /**
     * @var \AppBundle\Entity\Languages
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Languages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_language", referencedColumnName="id")
     * })
     */
    private $fkLanguage;

    /**
     * @var \AppBundle\Entity\Genres
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Genres")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_genre", referencedColumnName="id")
     * })
     */
    private $fkGenre;

    /**
     * @var \AppBundle\Entity\BooksAdmins
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BooksAdmins")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_books_admin", referencedColumnName="id")
     * })
     */
    private $fkBooksAdmin;

    /**
     * @var \AppBundle\Entity\Authors
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Authors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_author", referencedColumnName="id")
     * })
     */
    private $fkAuthor;


    /**
     * @ORM\OneToMany(targetEntity="Orders", mappedBy="fkBook", cascade={"persist"})
     */
    private $orders;


    public function setOrders($order)
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
        }
        return $this;
    }

    public function getOrders()
    {
        return $this->orders;
    }


    /**
     * Set isbnCode
     *
     * @param string $isbnCode
     *
     * @return Books
     */
    public function setIsbnCode($isbnCode)
    {
        $this->isbnCode = $isbnCode;

        return $this;
    }

    /**
     * Get isbnCode
     *
     * @return string
     */
    public function getIsbnCode()
    {
        return $this->isbnCode;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Books
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set year
     *
     * @param \DateTime $year
     *
     * @return Books
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \DateTime
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set pageCount
     *
     * @param integer $pageCount
     *
     * @return Books
     */
    public function setPageCount($pageCount)
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    /**
     * Get pageCount
     *
     * @return integer
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * Set ordered
     *
     * @param boolean $ordered
     *
     * @return Books
     */
    public function setOrdered($ordered)
    {
        $this->ordered = $ordered;

        return $this;
    }

    /**
     * Get ordered
     *
     * @return boolean
     */
    public function getOrdered()
    {
        return $this->ordered;
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
     * Set fkPublisher
     *
     * @param \AppBundle\Entity\Publishers $fkPublisher
     *
     * @return Books
     */
    public function setFkPublisher(\AppBundle\Entity\Publishers $fkPublisher = null)
    {
        $this->fkPublisher = $fkPublisher;

        return $this;
    }

    /**
     * Get fkPublisher
     *
     * @return \AppBundle\Entity\Publishers
     */
    public function getFkPublisher()
    {
        return $this->fkPublisher;
    }

    /**
     * Set fkLanguage
     *
     * @param \AppBundle\Entity\Languages $fkLanguage
     *
     * @return Books
     */
    public function setFkLanguage(\AppBundle\Entity\Languages $fkLanguage = null)
    {
        $this->fkLanguage = $fkLanguage;

        return $this;
    }

    /**
     * Get fkLanguage
     *
     * @return \AppBundle\Entity\Languages
     */
    public function getFkLanguage()
    {
        return $this->fkLanguage;
    }

    /**
     * Set fkGenre
     *
     * @param \AppBundle\Entity\Genres $fkGenre
     *
     * @return Books
     */
    public function setFkGenre(\AppBundle\Entity\Genres $fkGenre = null)
    {
        $this->fkGenre = $fkGenre;

        return $this;
    }

    /**
     * Get fkGenre
     *
     * @return \AppBundle\Entity\Genres
     */
    public function getFkGenre()
    {
        return $this->fkGenre;
    }

    /**
     * Set fkBooksAdmin
     *
     * @param \AppBundle\Entity\BooksAdmins $fkBooksAdmin
     *
     * @return Books
     */
    public function setFkBooksAdmin(\AppBundle\Entity\BooksAdmins $fkBooksAdmin = null)
    {
        $this->fkBooksAdmin = $fkBooksAdmin;

        return $this;
    }

    /**
     * Get fkBooksAdmin
     *
     * @return \AppBundle\Entity\BooksAdmins
     */
    public function getFkBooksAdmin()
    {
        return $this->fkBooksAdmin;
    }

    /**
     * Set fkAuthor
     *
     * @param \AppBundle\Entity\Authors $fkAuthor
     *
     * @return Books
     */
    public function setFkAuthor(\AppBundle\Entity\Authors $fkAuthor = null)
    {
        $this->fkAuthor = $fkAuthor;

        return $this;
    }

    /**
     * Get fkAuthor
     *
     * @return \AppBundle\Entity\Authors
     */
    public function getFkAuthor()
    {
        return $this->fkAuthor;
    }
}
