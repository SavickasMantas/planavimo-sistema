<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Schedule
 *
 * @ORM\Table(name="schedule", uniqueConstraints={@ORM\UniqueConstraint(name="ID_UNIQUE", columns={"ID"})})
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleRepository")
 */
class Schedule
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Title must be at least {{ limit }} characters long."
     * )
     * @Assert\Regex(
     *     "/^[a-z A-Z]+$/",
     *     message="Incorrect format of title."
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Description must be at least {{ limit }} characters long."
     * )
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="scheduled_end_date", type="datetime", nullable=false)
     */
    private $scheduledEndDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="fkSchedule")
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /*public function getScheduledEndDate(): ?\DateTimeInterface
    {
        return $this->scheduledEndDate;
    }*/
    public function getScheduledEndDate(): string
    {
        if ($this->scheduledEndDate !== null){
            return $this->scheduledEndDate->format('Y-m-d H:i');
        }else{
            return "";
        }

    }

    public function setScheduledEndDate(string $scheduledEndDate): self
    {
        try {

            $this->scheduledEndDate = new \DateTime($scheduledEndDate);
        }
        catch(\Exception $e) {
            //Do Nothing
        }

        return $this;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task){
        $this->tasks->add($task);
    }
}
