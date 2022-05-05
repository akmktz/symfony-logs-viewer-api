<?php

namespace App\Entity;

use App\Repository\LogFileItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogFileItemRepository::class)]
class LogFileItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $date_time;

    #[ORM\Column(type: 'text')]
    private $data;

    #[ORM\ManyToOne(targetEntity: LogFile::class, inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private $log_file_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->date_time;
    }

    public function setDateTime(\DateTimeInterface $date_time): self
    {
        $this->date_time = $date_time;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getLogFileId(): ?LogFile
    {
        return $this->log_file_id;
    }

    public function setLogFileId(?LogFile $log_file_id): self
    {
        $this->log_file_id = $log_file_id;

        return $this;
    }

    public function toArray()
    {
        return [
            'date_time' => $this->getDateTime(),
            'data' => $this->getData(),
        ];
    }
}
