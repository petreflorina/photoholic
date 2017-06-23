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

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Helper\EntityHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({
     *     "picture-get-many-comments",
     * })
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     *
     * @Groups({
     *     "picture-get-many-comments",
     * })
     */
    private $content;

    /**
     * ---------------------- JOINS ----------------------------------
     */

    /**
     * @var Picture
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Picture", inversedBy="comments")
     */
    private $picture;

    /**
     * @var User $createdBy
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", onDelete="RESTRICT")
     *
     * @Groups({
     *     "picture-get-many-comments"
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
     *     "picture-get-many-comments"
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
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set picture
     *
     * @param Picture $picture
     *
     * @return Comment
     */
    public function setPicture(Picture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comment
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
     * @return Comment
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
     * @return Comment
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
     * @return Comment
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
