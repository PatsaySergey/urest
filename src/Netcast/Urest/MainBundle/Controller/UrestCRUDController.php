<?php

namespace Netcast\Urest\MainBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UrestCRUDController extends Controller
{
    public function configCityAction()
    {
        $em   = $this->getDoctrine()->getManager();
        $city = $em->getRepository('Netcast\Urest\MainBundle\Entity\City')->findAll();

        $object = $this->admin->getNewInstance();

        return $this->render('NetcastUrestMainBundle:CRUD:edit_tour_city.html.twig', array(
            'action' => 'create',
            'object' => $object,
            'city'   => $city
        ));
    }

    /**
     * Create action
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function createAction()
    {
        // the key used to lookup the template
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {

                if (false === $this->admin->isGranted('CREATE', $object)) {
                    throw new AccessDeniedException();
                }

                try {
                    $object = $this->admin->create($object);

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                                'result'   => 'ok',
                                'objectId' => $this->admin->getNormalizedIdentifier($object)
                        ));
                    }

                    $this->addFlash('sonata_flash_success', $this->admin->trans('flash_create_success', array(
                            '%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash('sonata_flash_error', $this->admin->trans('flash_create_error', array(
                            '%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        $parentId = ($this->getRequest()->query->has('parent')) ? $this->getRequest()->query->get('parent') : null;
        $this->admin->setParentId($parentId);



        return $this->render($this->admin->getTemplate($templateKey), array(
                'action' => 'create',
                'form'   => $view,
                'object' => $object,
        ));
    }

    /**
     * List action
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $showDelete = $this->getRequest()->get('show_deleted');
        if ($showDelete !== null) $this->admin->setShowDelete(true);

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), array(
                'action'     => 'list',
                'form'       => $formView,
                'datagrid'   => $datagrid,
                'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ));
    }

    /**
     * Redirect the user depend on this choice
     *
     * @param object $object
     *
     * @return RedirectResponse
     */
    protected function redirectTo($object)
    {
        $url = false;

        $parentId = ($this->getRequest()->query->has('parent')) ? $this->getRequest()->query->get('parent') : null;

        if (null !== $this->get('request')->get('btn_update_and_list')) {
            $url = $this->admin->generateUrl('list');
        }
        if (null !== $this->get('request')->get('btn_create_and_list')) {
            $url = $this->admin->generateUrl('list');
        }

        if (null !== $this->get('request')->get('btn_create_and_create')) {
            $params = array();
            if ($this->admin->hasActiveSubClass()) {
                $params['subclass'] = $this->get('request')->get('subclass');
            }
            $url = ($parentId === null) ? $this->admin->generateUrl('create', $params) : $this->admin->generateUrl('create', $params) . '?parent=' . $parentId;
        }

        if (null !== $this->get('request')->get('btn_create_and_show_parent')) {
            $params = array();
            if ($this->admin->hasActiveSubClass()) {
                $params['subclass'] = $this->get('request')->get('subclass');
            }

            if (null !== $parentId and null !== $this->admin->getParentManager()) {
                $params['id'] = $parentId;
                $url          = $this->container->get($this->admin->getParentManager())->generateUrl('edit', $params);
            } else $url = $this->admin->generateUrl('list');
        }

        if (null !== $this->get('request')->get('btn_update_and_show_parent')) {
            $params = array();
            if ($this->admin->hasActiveSubClass()) {
                $params['subclass'] = $this->get('request')->get('subclass');
            }

            if (null !== $parentId) {
                $params['id'] = $parentId;
                $url          = $this->container->get($this->admin->getParentManager())->generateUrl('edit', $params);
            } else $url = $this->admin->generateUrl('list');
        }

        if ($this->getRestMethod() == 'DELETE') {

            $url = $this->admin->generateUrl('list');
        }

        if (!$url) {
            $url = $this->admin->generateObjectUrl('edit', $object);
        }

        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters['admin']         = isset($parameters['admin']) ? $parameters['admin'] : $this->admin;
        $parameters['base_template'] = isset($parameters['base_template']) ? $parameters['base_template'] : $this->getBaseTemplate();
        $parameters['admin_pool']    = $this->get('sonata.admin.pool');

        //Generate review notices
        $notice = $this->container->get('netcast_urest_main.notice');
        $notice->setCurrentLocale($this->getRequest()->getLocale());

        $reviewNotice            = $notice->getReviewNotice();
        $reviewAdmin             = $this->container->get('sonata.admin.review');
        $reviewNotice['listUrl'] = $reviewAdmin->generateUrl('list');
        foreach ($reviewNotice['notice'] as $key => $row) {
            $reviewNotice['notice'][$key]['editUrl'] = $reviewAdmin->generateUrl('edit', ['id' => $row['id']]);
        }
        $parameters['reviewNotice'] = $reviewNotice;

        //End Generate review notices

        $newOrderNotice            = $notice->getNewOrderNotice();
        $orderAdmin                = $this->container->get('sonata.admin.custom_tour');
        $newOrderNotice['listUrl'] = $orderAdmin->generateUrl('list');
        foreach ($newOrderNotice['notice'] as $key => $row) {
            $newOrderNotice['notice'][$key]['showUrl'] = $orderAdmin->generateUrl('show', ['id' => $row['id']]);
        }
        $parameters['newOrderNotice'] = $newOrderNotice;


        $editOrderNotice            = $notice->getEditOrderNotice();
        $orderAdmin                 = $this->container->get('sonata.admin.my_custom_tour');
        $editOrderNotice['listUrl'] = $orderAdmin->generateUrl('list');
        foreach ($editOrderNotice['notice'] as $key => $row) {
            $editOrderNotice['notice'][$key]['editUrl'] = $orderAdmin->generateUrl('edit', ['id' => $row['id']]);
        }
        $parameters['editOrderNotice'] = $editOrderNotice;


        return parent::render($view, $parameters, $response);
    }

    /**
     * Delete action
     *
     * @param int|string|null $id
     *
     * @return Response|RedirectResponse
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function deleteAction($id)
    {
        $id     = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('DELETE', $object)) {
            throw new AccessDeniedException();
        }

        if ($this->getRestMethod() == 'DELETE') {
            // check the csrf token
            $this->validateCsrfToken('sonata.delete');

            try {

                if (method_exists($object, 'setDeleted') && !$object->getDeleted()) {
                    $object->setDeleted(true);
                    $this->admin->update($object);
                } else {
                    $this->admin->delete($object);
                }

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                            'result' => 'ok'));
                }

                $this->addFlash(
                    'sonata_flash_success', $this->admin->trans(
                        'flash_delete_success', array(
                        '%name%' => $this->admin->toString($object)), 'SonataAdminBundle'
                    )
                );
            } catch (ModelManagerException $e) {

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                            'result' => 'error'));
                }

                $this->addFlash(
                    'sonata_flash_error', $this->admin->trans(
                        'flash_delete_error', array(
                        '%name%' => $this->admin->toString($object)), 'SonataAdminBundle'
                    )
                );
            }
            $this->getRequest()->getLocale();
            return $this->redirectTo($object);
        }

        return $this->render($this->admin->getTemplate('delete'), array(
                'object'     => $object,
                'action'     => 'delete',
                'csrf_token' => $this->getCsrfToken('sonata.delete')
        ));
    }

    public function takeAction()
    {
        $id     = $this->get('request')->get('objectId');
        $object = $this->admin->getObject($id);
        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }
        $tourModerator = $object->getModerator();

        if (!is_null($tourModerator)) {
            $this->getRequest()->getSession()->getFlashBag()->add("sonata_flash_error", "Этот заказ уже обрабатывается");
            return $this->redirect($this->admin->generateUrl('list'));
        }
        $object->setModerator($this->getUser());
        $this->admin->update($object);
        return $this->redirect($this->get('sonata.admin.my_custom_tour')->generateUrl('edit',['id' => $id]));
    }

    public function restoreAction()
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }
        $object->setDeleted(false);
        $this->admin->update($object);


        $this->addFlash('sonata_flash_success', 'Restored successfully');

        return new RedirectResponse($this->admin->generateUrl('list') . '?show_deleted=1');
    }
}