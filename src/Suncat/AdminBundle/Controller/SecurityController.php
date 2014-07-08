<?php

namespace Suncat\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityController
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class SecurityController extends Controller
{
    /**
     * Login action controller
     *
     * @return RedirectResponse
     */
    public function loginAction()
    {
        /* @var \Symfony\Component\HttpFoundation\Request $request */
        $request = $this->container->get('request');
        $session = $request->getSession();

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {

            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        if ($this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            $refererUri = $request->server->get('HTTP_REFERER');

            return new RedirectResponse(
                $refererUri && $refererUri != $request->getUri() ?
                $refererUri : $this->container->get('router')->generate('test_media')
            );
        }

        if ($request->isXmlHttpRequest()) {
            return new Response('{"error":"AUTHENTICATION_ERROR"}', 403);
        }

        return $this->container->get('templating')->renderResponse(
            'SuncatAdminBundle:Security:login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error,
                'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
                'admin_pool' => $this->container->get('sonata.admin.pool')
            )
        );
    }
}
