<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Form\MessageForm;
use Application\Service\MessageService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $entityManager;

    public function indexAction()
    {
        $form = new MessageForm($this->getEntityManager());

        $request = $this->getRequest();
        if ($request->isPost())
        {
            $data_post = array(
                'csrf' => $this->getRequest()->getPost('csrf'),
                'fieldset_staff' => array(
                    'id_unit' => $this->getRequest()->getPost('fieldset_staff')['id_unit'],
                    'name' => $this->getRequest()->getPost('fieldset_staff')['name'],
                    'email' => $this->getRequest()->getPost('fieldset_staff')['email'],
                    'departament' => $this->getRequest()->getPost('fieldset_staff')['departament'],
                ),
                'fieldset_message' => array(
                    'description' => $this->getRequest()->getPost('fieldset_message')['description'],
                    'image' => $this->getRequest()->getFiles('fieldset_message')['image'],
                )
            );

            $form->setData($data_post);
            if ($form->isValid())
            {
                $data_form = $form->getData();

                $service_message = new MessageService($this->getEntityManager());
                $service_message->insert($data_form);

                return $this->redirect()->toRoute('home/thankyou');
            }
            else
            {
                $data_form = $form->getData();
                if(file_exists($data_form['fieldset_message']['image']['tmp_name']))
                {
                    unlink($data_form['fieldset_message']['image']['tmp_name']);
                }
            }
        }

        return array(
            'form' => $form,
        );
    }

    public function thankYouAction(){

    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }


}
