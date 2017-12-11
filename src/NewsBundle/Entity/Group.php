<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.12.17
 * Time: 12:10
 */

namespace NewsBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use NewsBundle\Constraint\UniqueGroup;

/**
 * Class Group
 * @package NewsBundle\Entity
 *
 * @Entity(repositoryClass="NewsBundle\Repository\GroupRepository")
 * @Mapping\Table(name="news_group")
 * @HasLifecycleCallbacks
 */
class Group
{
    /**
     * @var int
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Column(name="title", unique=true)
     * @UniqueGroup()
     */
    private $title = '';

    /**
     * @var bool
     * @Mapping\Column(name="hidden", type="boolean")
     */
    private $hidden = false;

    /**
     * @var DateTime
     * @Mapping\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /** @var DateTime
     * @Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var ArrayCollection
     * @OneToMany(targetEntity="News", mappedBy="group")
     */
    private $news;

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->news = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden(bool $hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param News $news
     */
    public function addNews(News $news)
    {
        $this->news[] = $news;
    }

    /**
     * @return ArrayCollection
     */
    public function getNews()
    {
        return $this->news;
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