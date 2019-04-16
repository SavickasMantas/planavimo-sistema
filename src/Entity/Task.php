<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Task
 *
 * @ORM\Table(name="task", uniqueConstraints={@ORM\UniqueConstraint(name="ID_UNIQUE", columns={"ID"})}, indexes={@ORM\Index(name="FK_TASK_SCHEDULE_ID_idx", columns={"fk_schedule_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
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
     * @var string
     *
     * @ORM\Column(name="detail", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Detail must be at least {{ limit }} characters long."
     * )
     */
    private $detail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="task_end_date", type="datetime", nullable=false)
     */
    private $taskEndDate;

    /**
     * @var \Schedule
     *
     * @ORM\ManyToOne(targetEntity="Schedule", inversedBy="tasks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_schedule_id", referencedColumnName="ID", nullable=false, onDelete="CASCADE")
     * })
     */
    private $fkSchedule;

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

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

   /* public function getTaskEndDate(): ?\DateTimeInterface
    {
        return $this->taskEndDate;
    } */
    public function getTaskEndDate(): string
    {
        if ($this->taskEndDate !== null){
            return $this->taskEndDate->format('Y-m-d H:i');
        }else{
            return "";
        }
    }

    public function setTaskEndDate(string $taskEndDate): self
    {
        try {

            $this->taskEndDate = new \DateTime($taskEndDate);
        }
        catch(\Exception $e) {
            //Do Nothing
        }
        return $this;
    }

    public function getFkSchedule(): ?Schedule
    {
        return $this->fkSchedule;
    }

    public function setFkSchedule(?Schedule $fkSchedule): self
    {
        $this->fkSchedule = $fkSchedule;

        return $this;
    }


}
