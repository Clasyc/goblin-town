<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservations
 *
 * @ORM\Table(name="reservations", indexes={@ORM\Index(name="fkc_reservation_to_reader_idx", columns={"fk_reader"}), @ORM\Index(name="fkc_reservation_to_book_idx", columns={"fk_book"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ReservationsRepository")
 */
class Reservations
{
    const RESERVED = "reserved";
    const CANCELLED = "cancelled";
    const ORDERING = "ordering";
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="queue", type="integer", nullable=false)
     */
    private $queue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="queue_moved", type="datetime", nullable=false)
     */
    private $queueMoved;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private $status;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Reservations
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set queue
     *
     * @param integer $queue
     *
     * @return Reservations
     */
    public function setQueue($queue)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * Get queue
     *
     * @return integer
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * Set queueMoved
     *
     * @param \DateTime $queueMoved
     *
     * @return Reservations
     */
    public function setQueueMoved($queueMoved)
    {
        $this->queueMoved = $queueMoved;

        return $this;
    }

    /**
     * Get queueMoved
     *
     * @return \DateTime
     */
    public function getQueueMoved()
    {
        return $this->queueMoved;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Reservations
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
     * @return Reservations
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
     * @return Reservations
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
