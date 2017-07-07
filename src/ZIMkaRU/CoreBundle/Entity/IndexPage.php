<?php
/**
 * Created by PhpStorm.
 * User: voronkov_vs
 * Date: 12.07.2016
 * Time: 16:33
 */

namespace ZIMkaRU\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class IndexPage extends Image
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoImageOriginal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $feedbackImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $feedbackImageOriginal;

//    /**
//     * @ORM\ManyToOne(targetEntity="PortfolioGallery", inversedBy="indexPages")
//     * @ORM\JoinColumn(name="portfolioGallery_id", referencedColumnName="id")
//     */
//    private $portfolioGallery;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="BaseGallery", inversedBy="indexPages")
//     * @ORM\JoinColumn(name="baseGallery_id", referencedColumnName="id")
//     */
//    private $baseGallery;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $feedbackHeader;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 600
     * )
     */
    private $feedbackBody;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $feedbackLabelName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 60
     * )
     */
    private $feedbackLabelEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 60
     * )
     */
    private $feedbackLabelPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 60
     * )
     */
    private $feedbackLabelBtnSub;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $propositionHeader;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 600
     * )
     */
    private $propositionBody;

    /**
     * @ORM\OneToMany(targetEntity="PropositionItem", mappedBy="indexPage", cascade={"persist", "remove"})
     */
    private $propositionItems;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $featuresHeader;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 60
     * )
     */
    private $featuresLabelBtnSub;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $featuresImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $featuresImageOriginal;

    /**
     * @ORM\OneToMany(targetEntity="FeaturesItem", mappedBy="indexPage", cascade={"persist", "remove"})
     */
    private $featuresItems;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $portfolioHeader;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 600
     * )
     */
    private $portfolioBody;

    /**
     * @ORM\OneToMany(targetEntity="PortfolioItem", mappedBy="indexPage", cascade={"persist", "remove"})
     */
    private $portfolioItems;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $numbersHeader;

    /**
     * @ORM\OneToMany(targetEntity="NumbersItem", mappedBy="indexPage", cascade={"persist", "remove"})
     */
    private $numbersItems;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $contactsHeader;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 20
     * )
     */
    private $contactsPhone;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(
     *      min = 4,
     *      max = 50
     * )
     */
    private $contactsEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactsPhoneImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactsPhoneImageOriginal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactsEmailImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactsEmailImageOriginal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $footerLabel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $galleryHeader;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 150
     * )
     */
    private $galleryLabel;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $gallery;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $keywords;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    public function getImageFields()
    {
        return array(
            "logoImage",
            "feedbackImage",
            "featuresImage",
            "contactsPhoneImage",
            "contactsEmailImage",
            "gallery",
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
        $this->active = false;
        $this->propositionItems = new ArrayCollection();
        $this->featuresItems = new ArrayCollection();
        $this->numbersItems = new ArrayCollection();
        $this->portfolioItems = new ArrayCollection();
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
     * @return IndexPage
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
     * Set active
     *
     * @param boolean $active
     *
     * @return IndexPage
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return IndexPage
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
     * Set feedbackHeader
     *
     * @param string $feedbackHeader
     *
     * @return IndexPage
     */
    public function setFeedbackHeader($feedbackHeader)
    {
        $this->feedbackHeader = $feedbackHeader;

        return $this;
    }

    /**
     * Get feedbackHeader
     *
     * @return string
     */
    public function getFeedbackHeader()
    {
        return $this->feedbackHeader;
    }

    /**
     * Set feedbackBody
     *
     * @param string $feedbackBody
     *
     * @return IndexPage
     */
    public function setFeedbackBody($feedbackBody)
    {
        $this->feedbackBody = $feedbackBody;

        return $this;
    }

    /**
     * Get feedbackBody
     *
     * @return string
     */
    public function getFeedbackBody()
    {
        return $this->feedbackBody;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return IndexPage
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
     * Set feedbackLabelName
     *
     * @param string $feedbackLabelName
     *
     * @return IndexPage
     */
    public function setFeedbackLabelName($feedbackLabelName)
    {
        $this->feedbackLabelName = $feedbackLabelName;

        return $this;
    }

    /**
     * Get feedbackLabelName
     *
     * @return string
     */
    public function getFeedbackLabelName()
    {
        return $this->feedbackLabelName;
    }

    /**
     * Set feedbackLabelEmail
     *
     * @param string $feedbackLabelEmail
     *
     * @return IndexPage
     */
    public function setFeedbackLabelEmail($feedbackLabelEmail)
    {
        $this->feedbackLabelEmail = $feedbackLabelEmail;

        return $this;
    }

    /**
     * Get feedbackLabelEmail
     *
     * @return string
     */
    public function getFeedbackLabelEmail()
    {
        return $this->feedbackLabelEmail;
    }

    /**
     * Set feedbackLabelPhone
     *
     * @param string $feedbackLabelPhone
     *
     * @return IndexPage
     */
    public function setFeedbackLabelPhone($feedbackLabelPhone)
    {
        $this->feedbackLabelPhone = $feedbackLabelPhone;

        return $this;
    }

    /**
     * Get feedbackLabelPhone
     *
     * @return string
     */
    public function getFeedbackLabelPhone()
    {
        return $this->feedbackLabelPhone;
    }

    /**
     * Set feedbackLabelBtnSub
     *
     * @param string $feedbackLabelBtnSub
     *
     * @return IndexPage
     */
    public function setFeedbackLabelBtnSub($feedbackLabelBtnSub)
    {
        $this->feedbackLabelBtnSub = $feedbackLabelBtnSub;

        return $this;
    }

    /**
     * Get feedbackLabelBtnSub
     *
     * @return string
     */
    public function getFeedbackLabelBtnSub()
    {
        return $this->feedbackLabelBtnSub;
    }

    /**
     * Set propositionHeader
     *
     * @param string $propositionHeader
     *
     * @return IndexPage
     */
    public function setPropositionHeader($propositionHeader)
    {
        $this->propositionHeader = $propositionHeader;

        return $this;
    }

    /**
     * Get propositionHeader
     *
     * @return string
     */
    public function getPropositionHeader()
    {
        return $this->propositionHeader;
    }

    /**
     * Set propositionBody
     *
     * @param string $propositionBody
     *
     * @return IndexPage
     */
    public function setPropositionBody($propositionBody)
    {
        $this->propositionBody = $propositionBody;

        return $this;
    }

    /**
     * Get propositionBody
     *
     * @return string
     */
    public function getPropositionBody()
    {
        return $this->propositionBody;
    }

    /**
     * Add propositionItem
     *
     * @param \ZIMkaRU\CoreBundle\Entity\PropositionItem $propositionItem
     *
     * @return IndexPage
     */
    public function addPropositionItem(\ZIMkaRU\CoreBundle\Entity\PropositionItem $propositionItem)
    {
        $this->propositionItems[] = $propositionItem;
        $propositionItem->setIndexPage($this);

        return $this;
    }

    /**
     * Remove propositionItem
     *
     * @param \ZIMkaRU\CoreBundle\Entity\PropositionItem $propositionItem
     */
    public function removePropositionItem(\ZIMkaRU\CoreBundle\Entity\PropositionItem $propositionItem)
    {
        $this->propositionItems->removeElement($propositionItem);
        $propositionItem->setIndexPage(null);
    }

    /**
     * Get propositionItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPropositionItems()
    {
        return $this->propositionItems;
    }

    /**
     * Set logoImage
     *
     * @param string $logoImage
     *
     * @return IndexPage
     */
    public function setLogoImage($logoImage)
    {
        $this->logoImage = $logoImage;

        return $this;
    }

    /**
     * Get logoImage
     *
     * @return string
     */
    public function getLogoImage()
    {
        return $this->logoImage;
    }

    /**
     * Set logoImageOriginal
     *
     * @param string $logoImageOriginal
     *
     * @return IndexPage
     */
    public function setLogoImageOriginal($logoImageOriginal)
    {
        $this->logoImageOriginal = $logoImageOriginal;

        return $this;
    }

    /**
     * Get logoImageOriginal
     *
     * @return string
     */
    public function getLogoImageOriginal()
    {
        return $this->logoImageOriginal;
    }

    /**
     * Set feedbackImage
     *
     * @param string $feedbackImage
     *
     * @return IndexPage
     */
    public function setFeedbackImage($feedbackImage)
    {
        $this->feedbackImage = $feedbackImage;

        return $this;
    }

    /**
     * Get feedbackImage
     *
     * @return string
     */
    public function getFeedbackImage()
    {
        return $this->feedbackImage;
    }

    /**
     * Set feedbackImageOriginal
     *
     * @param string $feedbackImageOriginal
     *
     * @return IndexPage
     */
    public function setFeedbackImageOriginal($feedbackImageOriginal)
    {
        $this->feedbackImageOriginal = $feedbackImageOriginal;

        return $this;
    }

    /**
     * Get feedbackImageOriginal
     *
     * @return string
     */
    public function getFeedbackImageOriginal()
    {
        return $this->feedbackImageOriginal;
    }

    /**
     * Set featuresHeader
     *
     * @param string $featuresHeader
     *
     * @return IndexPage
     */
    public function setFeaturesHeader($featuresHeader)
    {
        $this->featuresHeader = $featuresHeader;

        return $this;
    }

    /**
     * Get featuresHeader
     *
     * @return string
     */
    public function getFeaturesHeader()
    {
        return $this->featuresHeader;
    }

    /**
     * Set featuresLabelBtnSub
     *
     * @param string $featuresLabelBtnSub
     *
     * @return IndexPage
     */
    public function setFeaturesLabelBtnSub($featuresLabelBtnSub)
    {
        $this->featuresLabelBtnSub = $featuresLabelBtnSub;

        return $this;
    }

    /**
     * Get featuresLabelBtnSub
     *
     * @return string
     */
    public function getFeaturesLabelBtnSub()
    {
        return $this->featuresLabelBtnSub;
    }

    /**
     * Set featuresImage
     *
     * @param string $featuresImage
     *
     * @return IndexPage
     */
    public function setFeaturesImage($featuresImage)
    {
        $this->featuresImage = $featuresImage;

        return $this;
    }

    /**
     * Get featuresImage
     *
     * @return string
     */
    public function getFeaturesImage()
    {
        return $this->featuresImage;
    }

    /**
     * Set featuresImageOriginal
     *
     * @param string $featuresImageOriginal
     *
     * @return IndexPage
     */
    public function setFeaturesImageOriginal($featuresImageOriginal)
    {
        $this->featuresImageOriginal = $featuresImageOriginal;

        return $this;
    }

    /**
     * Get featuresImageOriginal
     *
     * @return string
     */
    public function getFeaturesImageOriginal()
    {
        return $this->featuresImageOriginal;
    }

    /**
     * Add featuresItem
     *
     * @param \ZIMkaRU\CoreBundle\Entity\FeaturesItem $featuresItem
     *
     * @return IndexPage
     */
    public function addFeaturesItem(\ZIMkaRU\CoreBundle\Entity\FeaturesItem $featuresItem)
    {
        $this->featuresItems[] = $featuresItem;
        $featuresItem->setIndexPage($this);

        return $this;
    }

    /**
     * Remove featuresItem
     *
     * @param \ZIMkaRU\CoreBundle\Entity\FeaturesItem $featuresItem
     */
    public function removeFeaturesItem(\ZIMkaRU\CoreBundle\Entity\FeaturesItem $featuresItem)
    {
        $this->featuresItems->removeElement($featuresItem);
        $featuresItem->setIndexPage(null);
    }

    /**
     * Get featuresItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFeaturesItems()
    {
        return $this->featuresItems;
    }

    /**
     * Set portfolioHeader
     *
     * @param string $portfolioHeader
     *
     * @return IndexPage
     */
    public function setPortfolioHeader($portfolioHeader)
    {
        $this->portfolioHeader = $portfolioHeader;

        return $this;
    }

    /**
     * Get portfolioHeader
     *
     * @return string
     */
    public function getPortfolioHeader()
    {
        return $this->portfolioHeader;
    }

    /**
     * Set portfolioBody
     *
     * @param string $portfolioBody
     *
     * @return IndexPage
     */
    public function setPortfolioBody($portfolioBody)
    {
        $this->portfolioBody = $portfolioBody;

        return $this;
    }

    /**
     * Get portfolioBody
     *
     * @return string
     */
    public function getPortfolioBody()
    {
        return $this->portfolioBody;
    }

    /**
     * Set numbersHeader
     *
     * @param string $numbersHeader
     *
     * @return IndexPage
     */
    public function setNumbersHeader($numbersHeader)
    {
        $this->numbersHeader = $numbersHeader;

        return $this;
    }

    /**
     * Get numbersHeader
     *
     * @return string
     */
    public function getNumbersHeader()
    {
        return $this->numbersHeader;
    }

    /**
     * Set contactsHeader
     *
     * @param string $contactsHeader
     *
     * @return IndexPage
     */
    public function setContactsHeader($contactsHeader)
    {
        $this->contactsHeader = $contactsHeader;

        return $this;
    }

    /**
     * Get contactsHeader
     *
     * @return string
     */
    public function getContactsHeader()
    {
        return $this->contactsHeader;
    }

    /**
     * Set contactsPhone
     *
     * @param string $contactsPhone
     *
     * @return IndexPage
     */
    public function setContactsPhone($contactsPhone)
    {
        $this->contactsPhone = $contactsPhone;

        return $this;
    }

    /**
     * Get contactsPhone
     *
     * @return string
     */
    public function getContactsPhone()
    {
        return $this->contactsPhone;
    }

    /**
     * Set contactsEmail
     *
     * @param string $contactsEmail
     *
     * @return IndexPage
     */
    public function setContactsEmail($contactsEmail)
    {
        $this->contactsEmail = $contactsEmail;

        return $this;
    }

    /**
     * Get contactsEmail
     *
     * @return string
     */
    public function getContactsEmail()
    {
        return $this->contactsEmail;
    }

    /**
     * Set contactsPhoneImage
     *
     * @param string $contactsPhoneImage
     *
     * @return IndexPage
     */
    public function setContactsPhoneImage($contactsPhoneImage)
    {
        $this->contactsPhoneImage = $contactsPhoneImage;

        return $this;
    }

    /**
     * Get contactsPhoneImage
     *
     * @return string
     */
    public function getContactsPhoneImage()
    {
        return $this->contactsPhoneImage;
    }

    /**
     * Set contactsPhoneImageOriginal
     *
     * @param string $contactsPhoneImageOriginal
     *
     * @return IndexPage
     */
    public function setContactsPhoneImageOriginal($contactsPhoneImageOriginal)
    {
        $this->contactsPhoneImageOriginal = $contactsPhoneImageOriginal;

        return $this;
    }

    /**
     * Get contactsPhoneImageOriginal
     *
     * @return string
     */
    public function getContactsPhoneImageOriginal()
    {
        return $this->contactsPhoneImageOriginal;
    }

    /**
     * Set contactsEmailImage
     *
     * @param string $contactsEmailImage
     *
     * @return IndexPage
     */
    public function setContactsEmailImage($contactsEmailImage)
    {
        $this->contactsEmailImage = $contactsEmailImage;

        return $this;
    }

    /**
     * Get contactsEmailImage
     *
     * @return string
     */
    public function getContactsEmailImage()
    {
        return $this->contactsEmailImage;
    }

    /**
     * Set contactsEmailImageOriginal
     *
     * @param string $contactsEmailImageOriginal
     *
     * @return IndexPage
     */
    public function setContactsEmailImageOriginal($contactsEmailImageOriginal)
    {
        $this->contactsEmailImageOriginal = $contactsEmailImageOriginal;

        return $this;
    }

    /**
     * Get contactsEmailImageOriginal
     *
     * @return string
     */
    public function getContactsEmailImageOriginal()
    {
        return $this->contactsEmailImageOriginal;
    }

    /**
     * Add portfolioItem
     *
     * @param \ZIMkaRU\CoreBundle\Entity\PortfolioItem $portfolioItem
     *
     * @return IndexPage
     */
    public function addPortfolioItem(\ZIMkaRU\CoreBundle\Entity\PortfolioItem $portfolioItem)
    {
        $this->portfolioItems[] = $portfolioItem;
        $portfolioItem->setIndexPage($this);

        return $this;
    }

    /**
     * Remove portfolioItem
     *
     * @param \ZIMkaRU\CoreBundle\Entity\PortfolioItem $portfolioItem
     */
    public function removePortfolioItem(\ZIMkaRU\CoreBundle\Entity\PortfolioItem $portfolioItem)
    {
        $this->portfolioItems->removeElement($portfolioItem);
        $portfolioItem->setIndexPage(null);
    }

    /**
     * Get portfolioItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPortfolioItems()
    {
        return $this->portfolioItems;
    }

    /**
     * Add numbersItem
     *
     * @param \ZIMkaRU\CoreBundle\Entity\NumbersItem $numbersItem
     *
     * @return IndexPage
     */
    public function addNumbersItem(\ZIMkaRU\CoreBundle\Entity\NumbersItem $numbersItem)
    {
        $this->numbersItems[] = $numbersItem;
        $numbersItem->setIndexPage($this);

        return $this;
    }

    /**
     * Remove numbersItem
     *
     * @param \ZIMkaRU\CoreBundle\Entity\NumbersItem $numbersItem
     */
    public function removeNumbersItem(\ZIMkaRU\CoreBundle\Entity\NumbersItem $numbersItem)
    {
        $this->numbersItems->removeElement($numbersItem);
        $numbersItem->setIndexPage(null);
    }

    /**
     * Get numbersItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNumbersItems()
    {
        return $this->numbersItems;
    }

    /**
     * Set footerLabel
     *
     * @param string $footerLabel
     *
     * @return IndexPage
     */
    public function setFooterLabel($footerLabel)
    {
        $this->footerLabel = $footerLabel;

        return $this;
    }

    /**
     * Get footerLabel
     *
     * @return string
     */
    public function getFooterLabel()
    {
        return $this->footerLabel;
    }

    /**
     * Set gallery
     *
     * @param array $gallery
     *
     * @return IndexPage
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return array
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set galleryHeader
     *
     * @param string $galleryHeader
     *
     * @return IndexPage
     */
    public function setGalleryHeader($galleryHeader)
    {
        $this->galleryHeader = $galleryHeader;

        return $this;
    }

    /**
     * Get galleryHeader
     *
     * @return string
     */
    public function getGalleryHeader()
    {
        return $this->galleryHeader;
    }

    /**
     * Set galleryLabel
     *
     * @param string $galleryLabel
     *
     * @return IndexPage
     */
    public function setGalleryLabel($galleryLabel)
    {
        $this->galleryLabel = $galleryLabel;

        return $this;
    }

    /**
     * Get galleryLabel
     *
     * @return string
     */
    public function getGalleryLabel()
    {
        return $this->galleryLabel;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return IndexPage
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
     * Set keywords
     *
     * @param string $keywords
     *
     * @return IndexPage
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return IndexPage
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
}
