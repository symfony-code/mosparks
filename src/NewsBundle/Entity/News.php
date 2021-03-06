<?php

namespace NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\Mapping\Column;
use DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="NewsBundle\Repository\NewsRepository")
 * @HasLifecycleCallbacks
 */
class News
{
    const HIDDEN_NO = 0;
    const HIDDEN_YES = 1;

    /**
     * @var int
     *
     * @Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Column(name="announce", type="text")
     */
    private $announce;

    /**
     * @var string
     *
     * @Column(name="text", type="text")
     */
    private $text;

    /**
     * @var string
     * @Column(name="image", type="string", length=1024);
     * @File(mimeTypes={ "image/*" });
     */
    private $image = '';

    /**
     * @var Group
     * @ManyToOne(targetEntity="Group", inversedBy="news")
     */
    private $group;

    /**
     * @var bool
     *
     * @Column(name="hidden", type="boolean", options={"default": "0"})
     */
    private $hidden;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return News
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
     * Set announce
     *
     * @param string $announce
     *
     * @return News
     */
    public function setAnnounce($announce)
    {
        $this->announce = $announce;

        return $this;
    }

    /**
     * Get announce
     *
     * @return string
     */
    public function getAnnounce()
    {
        return $this->announce;
    }


    /**
     * Set text
     *
     * @param string $text
     *
     * @return News
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set hidden
     *
     * @param boolean $hidden
     *
     * @return News
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * @return Group
     */
    public function getGroup(): ?Group
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup(Group $group = null)
    {
        $this->group = $group;
        if (!is_null($group)) {
            $this->group->addNews($this);
        }
    }


    /**
     * @param string $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return string|UploadedFile
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get hidden
     *
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return News
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     *
     * @return News
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }



    /** @PrePersist */
    public function doStuffOnPrePersist()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @PreUpdate
     */
    public function doStuffOnPreUpdate()
    {
        $this->updatedAt = new DateTime();
    }
}

