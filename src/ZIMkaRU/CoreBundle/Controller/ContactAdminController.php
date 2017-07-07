<?php

namespace ZIMkaRU\CoreBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ContactAdminController extends Controller
{
    public function readedAction($id)
    {
        if (!$this->admin->isGranted('EDIT') || !$this->admin->isGranted('DELETE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $object->setReaded(true);

        $this->admin->update($object);

        $this->addFlash('sonata_flash_success', 'Помеченно как прочитанное');

        return new RedirectResponse($this->admin->generateUrl('list'));

        // if you have a filtered list and want to keep your filters after the redirect
        // return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }
}
