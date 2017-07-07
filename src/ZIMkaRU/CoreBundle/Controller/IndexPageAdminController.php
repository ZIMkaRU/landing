<?php

namespace ZIMkaRU\CoreBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class IndexPageAdminController extends Controller
{
    public function cloneAction($id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        // Be careful, you may need to overload the __clone method of your object
        // to set its id to null !
        $clonedObject = clone $object;

        $clonedObject->setName($object->getName().' (Копия)');
        $clonedObject->setActive(false);

        $this->admin->create($clonedObject);

        $this->addFlash('sonata_flash_success', 'Cloned successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }

    public function activeAction($id)
    {
        if (!$this->admin->isGranted('EDIT') || !$this->admin->isGranted('DELETE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getSubject();
        $em = $this->getDoctrine()->getEntityManager();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $objectID = $object->getId();

        $qb = $em->createQueryBuilder();
        $query = $qb->update('ZIMkaRUCoreBundle:IndexPage', 'p')
            ->set('p.active', '?1')
            ->where($qb->expr()->not($qb->expr()->eq('p.id', '?2')))
            ->setParameter(1, false)
            ->setParameter(2, $objectID)
            ->getQuery();
        $query->execute();

        $object->setActive(true);

        $this->admin->update($object);

        $this->addFlash('sonata_flash_success', 'Активированно');

        return new RedirectResponse($this->admin->generateUrl('list'));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }
}
