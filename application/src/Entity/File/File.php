<?php
declare(strict_types=1);

/** @namespace */
namespace App\Entity\File;

/** @uses */
use Doctrine\ORM\Mapping as ORM;
use SplFileInfo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

/**
 * Class File
 *
 * @ORM\Entity(repositoryClass="App\Repository\File\FileRepository")
 * @UniqueEntity({"hash", "path"}, message="Такой файл уже существует")
 *
 * @package App\Entity\File
 */
class File implements FileInterface
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\GeneratedValue("UUID")
     * @ORM\Column(type="string")
     *
     * @Assert\Uuid()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank()
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank()
     */
    private $publicPath;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    private $extension;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $createdAt;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime()
     * @Assert\NotBlank()
     */
    private $updatedAt;

    /**
     * @var SymfonyFile
     *
     * @Assert\File(groups={"upload-request"})
     */
    private $file;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getPublicPath(): string
    {
        return $this->publicPath;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return null|File|UploadedFile|SplFileInfo
     */
    public function getFile(): ?SplFileInfo {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getFilenameWithExtension(): string
    {
        return $this->getId().'.'.$this->getExtension();
    }

    /**
     * @return string
     */
    public function getAbsoluteFilepath(): string
    {
        return $this->getPath().DIRECTORY_SEPARATOR.$this->getFilenameWithExtension();
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @param string $publicPath
     */
    public function setPublicPath(string $publicPath): void
    {
        $this->publicPath = $publicPath;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @param null|string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param \DateTimeInterface $updatedAt
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param SplFileInfo $file
     */
    public function setFile(SplFileInfo $file): void
    {
        $this->file = $file;
    }
}
