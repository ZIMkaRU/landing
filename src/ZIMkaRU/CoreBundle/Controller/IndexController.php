<?php

namespace ZIMkaRU\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZIMkaRU\CoreBundle\Entity\Contact;

class IndexController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('ZIMkaRUCoreBundle:IndexPage');
        $content = $repository->findOneBy(array('active' => true));

        if (!$content) {
            throw $this->createNotFoundException('Нет доступного контента');
        }

        return $this->render('ZIMkaRUCoreBundle:Index:index.html.twig', array('content' => $content));
    }

    public function addContactAction(Request $request)
    {
        // If AJAX request to decode JSON else response error 400
        if($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return new Response('Unable to parse request', Response::HTTP_BAD_REQUEST);
            }

            // Replace data
            $request->request->replace($data);

            // get field
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $phone = $request->request->get('phone');

            // logging
            $logger = $this->get('monolog.logger.elastica');

            $logger->debug('In addContactAction request JSON: ', [$data]);
            $logger->debug('data: ', [$name]);
            $logger->debug('data: ', [$email]);
            $logger->debug('data: ', [$phone]);

            $contact = new Contact();
            $contact->setName($name);
            $contact->setEmail($email);
            $contact->setPhone($phone);

            $validator = $this->get('validator');
            $errors = $validator->validate($contact);

            $serializer = $this->container->get('jms_serializer');
            $errorsSerialized = $serializer->serialize($errors, 'json');

            $logger->debug('data: ', [$errorsSerialized]);

            if (count($errors) > 0) {
                $response = new JsonResponse();
                $response->setData(array(
                    'state' => false,
                    'errors' => $errorsSerialized
                ));
                return $response;
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();

                $repository = $this->getDoctrine()->getRepository('ZIMkaRUCoreBundle:IndexPage');
                $content = $repository->findOneBy(array('active' => true));
                $imageLogo = $content->getLogoImage() ? $content->getWebPath('logoImage') : '#';

                $emailFrom = $this->getParameter('mailer_user');

                $message = \Swift_Message::newInstance()
                    ->setSubject('Отправка запроса')
                    ->setFrom($emailFrom)
                    ->setTo($email)
                    ->setBody(
                        $this->renderView(
                            'ZIMkaRUCoreBundle:Emails:contacts_posted.html.twig',
                            array('name' => $name, 'email' => $email, 'phone' => $phone, 'imageLogo' => $imageLogo)
                        ),
                        'text/html'
                    )
                ;
                $this->get('mailer')->send($message);

                $response = new JsonResponse();
                $response->setData(array(
                    'state' => true
                ));
                return $response;
            }
        } else {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }




    }
}
