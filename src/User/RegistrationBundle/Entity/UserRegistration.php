<?php

namespace User\RegistrationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
//use User\RegistrationBundle\Entity\UserRegistration;
/**
 * @ORM\Entity
 * @ORM\Table(name="user_registration")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Your E-Mail adress has already been registered"
 * )
 */
class UserRegistration
{
    /**
     * @var string
     * 
     * @ORM\Column (name="email", type="string", length=255, unique=true)
     * @Assert\Email();
     */
    private $email;

    /**
     * @var string
     *  @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     *  @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *  @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *  @ORM\Column(name="address", type="text")
     */
    private $address;

    /**
     * @var boolean
     *  @ORM\Column(name="gender", type="boolean")
     */
    private $gender;

    /**
     * @var boolean
     *  @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var \DateTime
     *  @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *  @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
    private $id;
    
    /**
   * @var string
   *
   * @ORM\Column(name="token", type="string", nullable=false)
   */
    private $token;




    public function checkUserLogin($email,$password)
    {
        
    }
    
    public function __toString() {
        return $this->firstName;
    }
    
    /**
     * Set AllData
     * 
     * Set All data of this class
     * 
     * @param Object $formData submitted all fields data
     */
    public function setAllData($formData)
    {
        $formArrayData=get_object_vars($formData);  // Convert Object to Array
        
        foreach ($formArrayData as $field=>$value) 
        {
            if( !is_object($value) && $field!='password') //if $value is not a Object and $value not equeal 'password'
            {
                call_user_func('User\RegistrationBundle\Entity\UserRegistration::set'.ucfirst($field),$value );  
            }
            else if(is_object($value))
            {
                $valueArray=  get_object_vars($value);  //Convert Object to Array
                call_user_func('User\RegistrationBundle\Entity\UserRegistration::set'.ucfirst($field),$valueArray['date']);
            }
        }
    }

    /**
     * Set email
     *
     * @param string $email
     * @return UserRegistration
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
     * Set password
     *
     * @param string $password
     * @return UserRegistration
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
     * Set firstName
     *
     * @param string $firstName
     * @return UserRegistration
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
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
     * Set lastName
     *
     * @param string $lastName
     * @return UserRegistration
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
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
     * Set address
     *
     * @param string $address
     * @return UserRegistration
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     * @return UserRegistration
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return boolean 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return UserRegistration
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserRegistration
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return UserRegistration
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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

    

    /**
     * Set token
     *
     * @param string $token
     * @return UserRegistration
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }
}