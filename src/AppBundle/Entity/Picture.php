<?php

namespace AppBundle\Entity;

/**
 * |--------------------------------------------------------------------------
 *
 * @author : Florina Petre, August 2016
 *
 * |--------------------------------------------------------------------------
 *
 *
 *
 *
 *
 */

use AppBundle\Helper\EntityHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Picture
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({
     *     "user-get-many-pictures",
     *      "picture-get-one",
     *      "tag-get-one",
     *     "picture-get-many-comments",
     *     "picture-edit"
     * })
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=50)
     *
     * @Groups({
     *     "user-get-many-pictures",
     *      "picture-get-one",
     *      "tag-get-one",
     *       "picture-edit"
     * })
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=10)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     *
     * @Groups({
     *     "user-get-many-pictures",
     *      "picture-get-one",
     *     "tag-get-one"
     * })
     */
    private $path;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     * @Assert\Type("array")
     *
     * @Groups({
     *      "picture-get-one"
     * })
     */
    private $exifData;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     *
     * @Groups({
     *      "picture-get-one",
     *      "picture-edit"
     * })
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     *
     * @Groups({
     *      "picture-get-one"
     * })
     */
    private $numberOfComments;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     */
    private $numberOfTags;

    /**
     * ---------------------- JOINS ----------------------------------
     */

    /**
     * @var Comment
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="picture", cascade={"persist", "remove"})
     *
     * @Groups({
     *     "picture-get-many-comments"
     * })
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $comments;

    /**
     * @var Tag
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", mappedBy="pictures", cascade={"persist"})
     *
     * @Groups({
     *     "user-get-many-pictures",
     *     "picture-get-one",
     *      "picture-edit"
     * })
     */
    private $tags;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="pictures")
     */
    private $user;

    /**
     * @var User $createdBy
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", onDelete="RESTRICT")
     *
     * @Groups({
     *      "picture-get-one"
     * })
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Groups({
     *     "user-get-many-pictures",
     *     "picture-get-one",
     *     "tag-get-one"
     * })
     */
    private $createdAt;

    /**
     * @var User $updatedBy
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", onDelete="RESTRICT")
     */
    private $updatedBy;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * ---------------------- END DEFINITIONS ----------------------------------
     */

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();

        $this->setNumberOfComments();
        $this->setNumberOfTags();
    }

    /**
     * Set numberOfTags
     *
     * @return Picture
     */
    public function setNumberOfTags()
    {
        $this->numberOfTags = count($this->getTags());

        return $this;
    }

    /**
     * Set numberOfComments
     *
     * @return Picture
     */
    public function setNumberOfComments()
    {
        $this->numberOfComments = count($this->getComments());

        return $this;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Picture
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;

        $this->setNumberOfComments();

        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);

        $this->setNumberOfComments();
    }

    /**
     * Add tag
     *
     * @param Tag $tag
     *
     * @return Picture
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;

        $this->setNumberOfTags();

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);

        $this->setNumberOfTags();
    }

    /**
     * Get updatedAt
     *
     * @param bool $returnFormatted
     * @return \DateTime
     */
    public function getUpdatedAt($returnFormatted = true)
    {
        return EntityHelper::getDateTime($this->updatedAt, $returnFormatted);
    }

    /**
     * Get createdAt
     *
     * @param bool $returnFormatted
     * @return \DateTime
     */
    public function getCreatedAt($returnFormatted = true)
    {
        return EntityHelper::getDateTime($this->createdAt, $returnFormatted);

    }

    /**
     * ---------------------- DELETE FROM HERE----------------------------------
     */

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
     * Set title
     *
     * @param string $title
     *
     * @return Picture
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
     * Set extension
     *
     * @param string $extension
     *
     * @return Picture
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Picture
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Picture
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set exifData
     *
     * @param array $exifData
     *
     * @return Picture
     */
    public function setExifData($exifData)
    {
        $this->exifData = $exifData;

        return $this;
    }

    /**
     * Get exifData
     *
     * @return array
     */
    public function getExifData()
    {
        return $this->exifData;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Picture
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get numberOfComments
     *
     * @return integer
     */
    public function getNumberOfComments()
    {
        return $this->numberOfComments;
    }

    /**
     * Get numberOfTags
     *
     * @return integer
     */
    public function getNumberOfTags()
    {
        return $this->numberOfTags;
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Picture
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Picture
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Picture
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Set createdBy
     *
     * @param User $createdBy
     *
     * @return Picture
     */
    public function setCreatedBy(User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param User $updatedBy
     *
     * @return Picture
     */
    public function setUpdatedBy(User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}
