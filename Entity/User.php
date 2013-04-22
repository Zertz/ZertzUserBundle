<?php
// Zertz/UserBundle/Entity/User.php
namespace Zertz\UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected $lastname;
    
    /**
     * @ORM\Column(name="website", type="string", length=64, nullable=true)
     */
    protected $website;

    /**
     * @ORM\Column(name="gender", type="string", length=1, nullable=true)
     */
    protected $gender;
    
    /**
     * @ORM\Column(name="locale", type="string", length=8, nullable=true)
     */
    protected $locale;
    
    /**
     * @ORM\Column(name="timezone", type="string", length=64, nullable=true)
     */
    protected $timezone;
    
    /**
     * @ORM\Column(name="facebook_uid", type="string", length=255, nullable=true)
     */
    protected $facebookId;
    
    /**
     * @ORM\Column(name="facebook_name", type="string", length=255, nullable=true)
     */
    protected $facebookName;

    public function serialize()
    {
        return serialize(array($this->facebookId, parent::serialize()));
    }

    public function unserialize($data)
    {
        list($this->facebookId, $parentData) = unserialize($data);
        parent::unserialize($parentData);
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
    
    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $lastname
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }
    
    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $lastname
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }
    
    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $lastname
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
    
    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param string $lastname
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastname();
    }

    /**
     * @param string $facebookId
     * @return void
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        $this->setUsername($facebookId);
        $this->salt = '';
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }
    
    /**
     * @param string $facebookId
     * @return void
     */
    public function setFacebookName($facebookName)
    {
        $this->facebookName = $facebookName;
    }

    /**
     * @return string
     */
    public function getFacebookName()
    {
        return $this->facebookName;
    }

    /**
     * @param Array
     */
    public function setFBData($fbdata)
    {
        //var_dump($fbdata);exit();
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
            $this->addRole('ROLE_FACEBOOK');
        }
        if (isset($fbdata['username'])) {
            $this->setFacebookName($fbdata['username']);
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstname($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastname($fbdata['last_name']);
        }
        if (isset($fbdata['link'])) {
            $this->setWebsite($fbdata['link']);
        }
        if (isset($fbdata['gender'])) {
            $this->setGender($fbdata['gender']);
        }
        if (isset($fbdata['locale'])) {
            $this->setLocale($fbdata['locale']);
        }
        if (isset($fbdata['timezone'])) {
            $this->setTimezone($fbdata['timezone']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        if ($this->firstname || $this->lastname) {
            return $this->firstname . ' ' . $this->lastname;
        } else {
            return $this->username;
        }
    }
    
    public function __toString()
    {
        if ($this->firstname || $this->lastname) {
            return $this->firstname . ' ' . $this->lastname;
        } else {
            return $this->username;
        }
    }
}
