<?php
namespace Application\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Fieldset\StaffFieldset;

class MessageForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('form_message');

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));

        $fieldset_staff = new StaffFieldset($objectManager);
        $fieldset_staff->setLabel('Seus Dados');
        $fieldset_staff->setName('fieldset_staff');
        $this->add($fieldset_staff);

        $this->add(array(
            'type' => 'Application\Fieldset\MessageFieldset',
            'name' => 'fieldset_message',
            'options' => array(
                'label' => 'Sua mensagem',
            )
        ));
    }
}