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
class PropositionItem extends Image
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $propositionImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $propositionImageOriginal;

    /**
     * @ORM\ManyToOne(targetEntity="IndexPage", inversedBy="propositionItems")
     * @ORM\JoinColumn(name="propositionIndexPage_id", referencedColumnName="id")
     */
    private $indexPage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $header;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 600
     * )
     */
    private $body;

    public function getImageFields()
    {
        return array(
            "propositionImage",
        );
    }

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
     * @return PropositionItem
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
     * @return PropositionItem
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
     * @return PropositionItem
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
     * Set header
     *
     * @param string $header
     *
     * @return PropositionItem
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return PropositionItem
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
     * @return PropositionItem
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
     * Set propositionImage
     *
     * @param string $propositionImage
     *
     * @return PropositionItem
     */
    public function setPropositionImage($propositionImage)
    {
        $this->propositionImage = $propositionImage;

        return $this;
    }

    /**
     * Get propositionImage
     *
     * @return string
     */
    public function getPropositionImage()
    {
        return $this->propositionImage;
    }

    /**
     * Set propositionImageOriginal
     *
     * @param string $propositionImageOriginal
     *
     * @return PropositionItem
     */
    public function setPropositionImageOriginal($propositionImageOriginal)
    {
        $this->propositionImageOriginal = $propositionImageOriginal;

        return $this;
    }

    /**
     * Get propositionImageOriginal
     *
     * @return string
     */
    public function getPropositionImageOriginal()
    {
        return $this->propositionImageOriginal;
    }
}
