<?php

namespace App\Entity;

use App\Repository\LogFileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogFileRepository::class)]
class LogFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $log_name;

    #[ORM\Column(type: 'bigint')]
    private $cached_size = 0;

    #[ORM\OneToMany(mappedBy: 'log_file_id', targetEntity: LogFileItem::class, orphanRemoval: true)]
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogName(): ?string
    {
        return $this->log_name;
    }

    public function setLogName(string $log_name): self
    {
        $this->log_name = $log_name;

        return $this;
    }

    public function getCachedSize(): ?int
    {
        return (int)$this->cached_size;
    }

    public function setCachedSize(int $cachedSize): self
    {
        $this->cached_size = $cachedSize;

        return $this;
    }

    /**
     * @return Collection<int, LogFileItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(LogFileItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setLogFileId($this);
        }

        return $this;
    }

    public function removeItem(LogFileItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getLogFileId() === $this) {
                $item->setLogFileId(null);
            }
        }

        return $this;
    }
}
