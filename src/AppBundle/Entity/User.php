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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Helper\EntityHelper;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({
     *     "user-get-one",
     *     "picture-get-one",
     *     "picture-get-many-comments"
     * })
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=40)
     *
     * @Groups({
     *     "user-get-one",
     *     "picture-get-one",
     *     "user-edit"
     * })
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     *
     * @Groups({
     *     "user-edit"
     * })
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=30)
     * @Assert\Email()
     *
     * @Groups({
     *     "user-get-one",
     *     "user-edit"
     * })
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=30)
     *
     * @Groups({
     *     "user-get-one",
     *     "user-edit"
     * })
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=30)
     *
     * @Groups({
     *     "user-get-one",
     *     "user-edit"
     * })
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     * @Assert\Length(max=60)
     *
     * @Groups({
     *     "user-get-one",
     *     "picture-get-many-comments"
     * })
     */
    private $firstLastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     * @Assert\Length(max=60)
     */
    private $lastFirstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     *
     * @Groups({
     *     "user-get-one",
     *     "picture-get-one",
     *     "user-edit"
     * })
     */
    private $cameraModel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     *
     * @Groups({
     *     "user-get-one"
     * })
     */
    private $photographerSince;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer")
     *
     * @Groups({
     *     "user-get-one"
     * })
     */
    private $numberOfPictures;

    /**
     * ---------------------- JOINS ----------------------------------
     */

    /**
     * @var Picture
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Picture", mappedBy="user")
     * @Groups({"user-get-many-pictures"})
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
     *
     * @Groups({
     *     "user-get-one"
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
        $this->pictures = new ArrayCollection();

        $this->setNumberOfPictures();
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = ucwords($firstName);

        $this->setFirstLastName();
        $this->setLastFirstName();

        return $this;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = ucwords($lastName);

        $this->setFirstLastName();
        $this->setLastFirstName();

        return $this;
    }

    /**
     * Set firstLastName
     *
     * @return User
     */
    public function setFirstLastName()
    {
        $this->firstLastName = $this->getFirstName() . ' ' . $this->getLastName();

        return $this;
    }

    /**
     * Set lastFirstName
     *
     * @return User
     */
    public function setLastFirstName()
    {
        $this->lastFirstName = $this->getLastName() . ' ' . $this->getFirstName();

        return $this;
    }

    /**
     * Set numberOfPictures
     *
     * @return User
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
     * @return User
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
     * Get createdAt
     *
     * @param bool $returnFormatted
     *
     * @return \DateTime|null|string
     */
    public function getCreatedAt($returnFormatted = true)
    {
        return EntityHelper::getDateTime($this->createdAt, $returnFormatted);
    }

    /**
     * Get photographerSince
     *
     * @param bool $returnFormatted
     * @return \DateTime
     */
    public function getPhotographerSince($returnFormatted = true)
    {
        return EntityHelper::getDateTime($this->photographerSince, $returnFormatted);
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }


    /**
     * Get firstLastName
     *
     * @return string
     */
    public function getFirstLastName()
    {
        return $this->firstLastName;
    }

    /**
     * Get lastFirstName
     *
     * @return string
     */
    public function getLastFirstName()
    {
        return $this->lastFirstName;
    }

    /**
     * Set cameraModel
     *
     * @param string $cameraModel
     *
     * @return User
     */
    public function setCameraModel($cameraModel)
    {
        $this->cameraModel = $cameraModel;

        return $this;
    }

    /**
     * Get cameraModel
     *
     * @return string
     */
    public function getCameraModel()
    {
        return $this->cameraModel;
    }

    /**
     * Set photographerSince
     *
     * @param \DateTime $photographerSince
     *
     * @return User
     */
    public function setPhotographerSince($photographerSince)
    {
        $this->photographerSince = $photographerSince;

        return $this;
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
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Set createdBy
     *
     * @param User $createdBy
     *
     * @return User
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
     * @return User
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

    /**
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
}
