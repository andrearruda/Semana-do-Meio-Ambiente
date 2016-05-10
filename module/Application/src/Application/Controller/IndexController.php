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
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $form = new MessageForm($objectManager);

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
                $pathinfo = pathinfo($data_form['fieldset_message']['image']['tmp_name']);

                $imgs = array(
                    'middle' => array(
                        'path' => substr($pathinfo['dirname'], 0, -9) . '/middle/' . $pathinfo['basename'],
                        'mode' => \Imagine\Image\ImageInterface::THUMBNAIL_INSET,
                        'size' => array(
                            'w' => 890,
                            'h' => 500
                        )
                    ),
                    'thumb' => array(
                        'path' => substr($pathinfo['dirname'], 0, -9) . '/thumb/' . $pathinfo['basename'],
                        'mode' => \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND,
                        'size' => array(
                            'w' => 200,
                            'h' => 200
                        )
                    )
                );

                $imagine = new Imagine();
                foreach($imgs as $img)
                {
                    $size = new Box($img['size']['w'], $img['size']['h']);
                    $imagine->open($data_form['fieldset_message']['image']['tmp_name'])
                        ->thumbnail($size, $img['mode'])
                        ->save($img['path']);
                }
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
}
