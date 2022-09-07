<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity]
#[Vich\Uploadable] 
class Music
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'music', fileNameProperty: 'musicName', size: 'musicSize')]
    private ?File $musicFile = null;

    #[ORM\Column(type: 'string')]
    private ?string $musicName = null;

    #[ORM\Column(type: 'integer')]
    private ?int $musicSize = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $musicFile
     */
    public function setMusicFile(?File $musicFile = null): void
    {
        $this->musicFile = $musicFile;

        if (null !== $musicFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getMusicFile(): ?File
    {
        return $this->musicFile;
    }

    public function setMusicName(?string $musicName): void
    {
        $this->musicName = $musicName;
    }

    public function getMusicName(): ?string
    {
        return $this->musicName;
    }
    
    public function setMusicSize(?int $musicSize): void
    {
        $this->musicSize = $musicSize;
    }

    public function getMusicSize(): ?int
    {
        return $this->musicSize;
    }
}