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
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag
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
     *     "picture-get-one",
     *     "tag-get-many-for-suggest",
     *     "tag-get-one",
     *      "picture-edit"
     * })
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=30)
     *
     * @Groups({
     *     "user-get-many-pictures",
     *     "picture-get-one",
     *     "tag-get-many-for-suggest",
     *     "tag-get-one"
     * })
     *
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     *
     * @Groups({
     *     "tag-get-one",
     *     "tag-get-many-for-suggest"
     * })
     */
    private $numberOfPictures;

    /**
     * ---------------------- JOINS ----------------------------------
     */

    /**
     * @var Picture
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Picture", inversedBy="tags")
     * @ORM\JoinTable(name="tags_pictures")
     *
     * @Groups({
     *     "tag-get-one"
     * })
     */
    private $pictures;

    /**
     * @var User $createdBy
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", onDelete="RESTRICT")
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
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
        $this->pictures = new ArrayCollection();

        $this->setNumberOfPictures();
    }

    /**
     * Set numberOfPictures
     *
     * @return Tag
     */
    public function setNumberOfPictures()
    {
        $this->numberOfPictures = count($this->getPictures());

        return $this;
    }

    /**
     * Add picture
     *
     * @param Picture $picture
     *
     * @return Tag
     */
    public function addPicture(Picture $picture)
    {
        $this->pictures[] = $picture;

        $this->setNumberOfPictures();

        return $this;
    }

    /**
     * Remove picture
     *
     * @param Picture $picture
     */
    public function removePicture(Picture $picture)
    {
        $this->pictures->removeElement($picture);

        $this->setNumberOfPictures();
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
     * Set name
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get numberOfPictures
     *
     * @return integer
     */
    public function getNumberOfPictures()
    {
        return $this->numberOfPictures;
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Tag
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
     * @return Tag
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
     * @return Tag
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
     * @return Tag
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
