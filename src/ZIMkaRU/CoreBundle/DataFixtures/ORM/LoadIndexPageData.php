<?php
/**
 * Created by PhpStorm.
 * User: voronkov_vs
 * Date: 06.09.2016
 * Time: 14:57
 */

namespace ZIMkaRU\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZIMkaRU\CoreBundle\Entity\FeaturesItem;
use ZIMkaRU\CoreBundle\Entity\IndexPage;
use ZIMkaRU\CoreBundle\Entity\NumbersItem;
use ZIMkaRU\CoreBundle\Entity\PortfolioItem;
use ZIMkaRU\CoreBundle\Entity\PropositionItem;

class LoadIndexPageData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    public function load(ObjectManager $manager)
    {
        $indexPage = new IndexPage();
        $indexPage->setName("Test content");
        $indexPage->setActive(true);
        $indexPage->setTitle("Test index page");
        $indexPage->setDescription("Test");
        $indexPage->setKeywords("Test");
        $indexPage->setFooterLabel('Label footer');

        $indexPage->setFeedbackHeader("Feedback");
        $indexPage->setFeedbackBody("Nullo possedit subdita verba diu nam videre regio adspirate. Dextra pondere caeca proxima distinxit habitabilis congestaque cura..");
        $indexPage->setFeedbackLabelName("Name");
        $indexPage->setFeedbackLabelEmail("Email");
        $indexPage->setFeedbackLabelPhone("Phone");
        $indexPage->setFeedbackLabelBtnSub("Send");

        $indexPage->setPropositionHeader('Proposition');
        $indexPage->setPropositionBody("Nullo possedit subdita verba diu nam videre regio adspirate. Dextra pondere caeca proxima distinxit habitabilis congestaque cura. Alto coercuit conversa ne. Animalibus deorum corpore. Aberant phoebe oppida secrevit omnia. Aethere posset: obliquis ulla erat: obstabatque congestaque. Tanta divino inter phoebe quem.");

        for ($i = 0; $i < 3; $i++) {
            $propositionItem = $this->createPropositionItem();
            $indexPage->addPropositionItem($propositionItem);
            $manager->persist($propositionItem);
        }

        $indexPage->setFeaturesHeader('Features');
        $indexPage->setFeaturesLabelBtnSub('Click');

        for ($i = 0; $i < 4; $i++) {
            $featuresItem = $this->createFeaturesItem();
            $indexPage->addFeaturesItem($featuresItem);
            $manager->persist($featuresItem);
        }

        $indexPage->setPortfolioHeader('Portfolio');
        $indexPage->setPortfolioBody("Nullo possedit subdita verba diu nam videre regio adspirate. Dextra pondere caeca proxima distinxit habitabilis congestaque cura. Alto coercuit conversa ne. Animalibus deorum corpore. Aberant phoebe oppida secrevit omnia. Aethere posset: obliquis ulla erat: obstabatque congestaque. Tanta divino inter phoebe quem.");

        for ($i = 0; $i < 8; $i++) {
            $portfolioItem = $this->createPortfolioItem();
            $indexPage->addPortfolioItem($portfolioItem);
            $manager->persist($portfolioItem);
        }

        $indexPage->setNumbersHeader('Numbers');

        for ($i = 0; $i < 6; $i++) {
            $numbersItem = $this->createNumbersItem();
            $indexPage->addNumbersItem($numbersItem);
            $manager->persist($numbersItem);
        }

        $indexPage->setContactsHeader('Contacts');
        $indexPage->setContactsPhone('+380994568727');
        $indexPage->setContactsEmail('VSVoronkov@gmail.com');

        $indexPage->setGalleryHeader('Gallery');
        $indexPage->setGalleryLabel('Label');

        $gallery = array();
        for ($j = 0; $j < 8; $j++) {
            $gallery[] = "holder.js/1000x500?random=yes&auto=yes&textmode=exact";
        }

        $indexPage->setGallery($gallery);

        $manager->persist($indexPage);
        $manager->flush();

        $this->addReference('indexPage', $indexPage);
    }

    private function createPropositionItem() : PropositionItem
    {
        $propositionItem = new PropositionItem();
        $propositionItem->setName('Proposition item');
        $propositionItem->setHeader('Header');
        $propositionItem->setBody('Induit sectamque facientes semina cuncta eodem. Congestaque grandia vindice tegit alta longo orbe rectumque!');

        return $propositionItem;
    }

    private function createFeaturesItem() : FeaturesItem
    {
        $featuresItem = new FeaturesItem();
        $featuresItem->setName('Features item');
        $featuresItem->setHeader('Header');
        $featuresItem->setBody('Induit sectamque facientes semina cuncta eodem. Congestaque grandia vindice tegit alta longo orbe rectumque!');

        return $featuresItem;
    }

    private function createPortfolioItem() : PortfolioItem
    {
        $portfolioItem = new PortfolioItem();
        $portfolioItem->setName('Portfolio item');
        $portfolioItem->setLabel('Label');
        $portfolioItem->setHeader('Header');
        $portfolioItem->setBody('Induit sectamque facientes semina cuncta eodem. Congestaque grandia vindice tegit alta longo orbe rectumque!');

        return $portfolioItem;
    }

    private function createNumbersItem() : NumbersItem
    {
        $numbersItem = new NumbersItem();
        $numbersItem->setName('Numbers item');
        $numbersItem->setNumber(200);
        $numbersItem->setPostNumbText('num');
        $numbersItem->setBody('Induit sectamque facientes semina cuncta eodem. Congestaque grandia vindice tegit alta longo orbe rectumque!');

        return $numbersItem;
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}