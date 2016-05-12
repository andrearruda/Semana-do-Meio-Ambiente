<?php
namespace Application\Controller;

use Application\Service\MessageService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class MessageController extends AbstractActionController
{
    protected $entityManager;

    public function indexAction()
    {
        $service_message = new MessageService($this->getEntityManager());
        $entities = $service_message->findAll();

        $page = $this->params()->fromRoute('page');
        $paginator = new Paginator(new ArrayAdapter($entities));
        $paginator->setCurrentPageNumber($page);

        $viewModel = new ViewModel(array(
            'data' => $paginator,
            'page' => $page
        ));

        return $viewModel;
    }

    public function showAction()
    {
        $id = $this->params()->fromRoute('id');
        $service_message = new MessageService($this->getEntityManager());

        $entity = $service_message->findById($id);

        $viewModel = new ViewModel(array(
            'entity' => $entity
        ));
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        $service_message = new MessageService($this->getEntityManager());

        $entity = $service_message->findById($id);

        $viewModel = new ViewModel(array(
            'entity' => $entity
        ));
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        $service_message = new MessageService($this->getEntityManager());

        $request = $this->getRequest();
        if ($request->isPost())
        {
            $service_message->delete($id);

            $data = array(
                'id' => $id
            );

            $jsonModel = new JsonModel($data);

            return $jsonModel;
        }
        else
        {
            $entity = $service_message->findById($id);

            $viewModel = new ViewModel(array(
                'entity' => $entity
            ));
            $viewModel->setTerminal(true);
            return $viewModel;
        }
    }

    public function activeAction()
    {
        $id = $this->params()->fromRoute('id');
        $data = array(
            'active' => $this->params()->fromQuery('active')
        );
        $service_message = new MessageService($this->getEntityManager());
        $message = $service_message->update($data, $id);

        $hydrator = new DoctrineHydrator($this->getEntityManager());
        $data = $hydrator->extract($message);

        $jsonModel = new JsonModel($data);

        return $jsonModel;
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