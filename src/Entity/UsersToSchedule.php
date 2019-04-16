<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersToSchedule
 *
 * @ORM\Table(name="users_to_schedule", uniqueConstraints={@ORM\UniqueConstraint(name="ID_UNIQUE", columns={"ID"})}, indexes={@ORM\Index(name="fk_USER_TO_SCHEDULE_ID_idx", columns={"fk_user_id"}), @ORM\Index(name="fk_SCHEDULE_ID_idx", columns={"fk_schedule_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\UsersToScheduleRepository")
 */
class UsersToSchedule
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
     * @var \Schedule
     *
     * @ORM\ManyToOne(targetEntity="Schedule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_schedule_id", referencedColumnName="ID", nullable=false, onDelete="CASCADE")
     * })
     */
    private $fkSchedule;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_user_id", referencedColumnName="ID", nullable=false, onDelete="CASCADE")
     * })
     */
    private $fkUser;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFkUser(): ?User
    {
        return $this->fkUser;
    }

    public function setFkUser(?User $fkUser): self
    {
        $this->fkUser = $fkUser;

        return $this;
    }


}
