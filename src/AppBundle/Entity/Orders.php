<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders", indexes={@ORM\Index(name="fkc_order_to_reader_idx", columns={"fk_reader"}), @ORM\Index(name="fkc_order_to_book_idx", columns={"fk_book"}), @ORM\Index(name="fkc_order_to_employe_idx", columns={"fk_employe"})})
 * @ORM\Entity
 */
class Orders
{
    const WAITING = "waiting";
    const CONFIRMED = "confirmed";
    const REJECTED = "rejected";
    const DEBT = "debt";
    const RETURNED = "returned";
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="take_date", type="datetime", nullable=false)
     */
    private $takeDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="agreed_return_date", type="date", nullable=false)
     */
    private $agreedReturnDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="actual_return_date", type="date", nullable=true)
     */
    private $actualReturnDate;

    /**
     * @var string
     *
     * @ORM\Column(name="take_conditions", type="string", length=10, nullable=false)
     */
    private $takeConditions;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="dept_rate_per_day", type="decimal", precision=3, scale=2, nullable=false)
     */
    private $deptRatePerDay;

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
     * @var \AppBundle\Entity\Employees
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employees")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_employe", referencedColumnName="table_id")
     * })
     */
    private $fkEmploye;

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
     * Set takeDate
     *
     * @param \DateTime $takeDate
     *
     * @return Orders
     */
    public function setTakeDate($takeDate)
    {
        $this->takeDate = $takeDate;

        return $this;
    }

    /**
     * Get takeDate
     *
     * @return \DateTime
     */
    public function getTakeDate()
    {
        return $this->takeDate;
    }

    /**
     * Set agreedReturnDate
     *
     * @param \DateTime $agreedReturnDate
     *
     * @return Orders
     */
    public function setAgreedReturnDate($agreedReturnDate)
    {
        $this->agreedReturnDate = $agreedReturnDate;

        return $this;
    }

    /**
     * Get agreedReturnDate
     *
     * @return \DateTime
     */
    public function getAgreedReturnDate()
    {
        return $this->agreedReturnDate;
    }

    /**
     * Set actualReturnDate
     *
     * @param \DateTime $actualReturnDate
     *
     * @return Orders
     */
    public function setActualReturnDate($actualReturnDate)
    {
        $this->actualReturnDate = $actualReturnDate;

        return $this;
    }

    /**
     * Get actualReturnDate
     *
     * @return \DateTime
     */
    public function getActualReturnDate()
    {
        return $this->actualReturnDate;
    }

    /**
     * Set takeConditions
     *
     * @param string $takeConditions
     *
     * @return Orders
     */
    public function setTakeConditions($takeConditions)
    {
        $this->takeConditions = $takeConditions;

        return $this;
    }

    /**
     * Get takeConditions
     *
     * @return string
     */
    public function getTakeConditions()
    {
        return $this->takeConditions;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Orders
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set deptRatePerDay
     *
     * @param string $deptRatePerDay
     *
     * @return Orders
     */
    public function setDeptRatePerDay($deptRatePerDay)
    {
        $this->deptRatePerDay = $deptRatePerDay;

        return $this;
    }

    /**
     * Get deptRatePerDay
     *
     * @return string
     */
    public function getDeptRatePerDay()
    {
        return $this->deptRatePerDay;
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
     * @return Orders
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
     * Set fkEmploye
     *
     * @param \AppBundle\Entity\Employees $fkEmploye
     *
     * @return Orders
     */
    public function setFkEmploye(\AppBundle\Entity\Employees $fkEmploye = null)
    {
        $this->fkEmploye = $fkEmploye;

        return $this;
    }

    /**
     * Get fkEmploye
     *
     * @return \AppBundle\Entity\Employees
     */
    public function getFkEmploye()
    {
        return $this->fkEmploye;
    }

    /**
     * Set fkBook
     *
     * @param \AppBundle\Entity\Books $fkBook
     *
     * @return Orders
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
