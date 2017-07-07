<?php
/**
 * Created by PhpStorm.
 * User: voronkov_vs
 * Date: 12.07.2016
 * Time: 16:33
 */

namespace ZIMkaRU\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class NumbersItem
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      max = 30
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="IndexPage", inversedBy="numbersItems")
     * @ORM\JoinColumn(name="indexPage_id", referencedColumnName="id")
     */
    private $indexPage;

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      max = 9999999
     * )
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $postNumbText;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 600
     * )
     */
    private $body;

    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     *
     * @return NumbersItem
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return NumbersItem
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
     *
     * @return NumbersItem
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
     * Set body
     *
     * @param string $body
     *
     * @return NumbersItem
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set indexPage
     *
     * @param \ZIMkaRU\CoreBundle\Entity\IndexPage $indexPage
     *
     * @return NumbersItem
     */
    public function setIndexPage(\ZIMkaRU\CoreBundle\Entity\IndexPage $indexPage = null)
    {
        $this->indexPage = $indexPage;

        return $this;
    }

    /**
     * Get indexPage
     *
     * @return \ZIMkaRU\CoreBundle\Entity\IndexPage
     */
    public function getIndexPage()
    {
        return $this->indexPage;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return NumbersItem
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set postNumbText
     *
     * @param string $postNumbText
     *
     * @return NumbersItem
     */
    public function setPostNumbText($postNumbText)
    {
        $this->postNumbText = $postNumbText;

        return $this;
    }

    /**
     * Get postNumbText
     *
     * @return string
     */
    public function getPostNumbText()
    {
        return $this->postNumbText;
    }
}
