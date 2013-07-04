<?php

namespace Events\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Transport;
use Zend\Mail\Message as Message;

class AdminTagsController extends AbstractActionController
{
    
    /**
     * Tag creation and edit Form 
     *  
     * @var \Zend\Form\Form
     */
    private $form;
    
    /**
     * Main service for handling tags
     * 
     * @var \Events\Service\TagService
     */
    private $tagService;
    
    
    /**
     * Class constructor
     * 
     * @param \Events\Service\TagService $tagService
     * @param \Zend\Form\Tag $form
     */
    public function __construct(\Events\Service\TagService $tagService, \Events\Form\Tag $form) {
        $this->tagService = $tagService;
        $this->form = $form;
    }
    
    /**
     * Returns a list of tags, as fethched from model
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
    	return new ViewModel(array('tags' => $this->tagService->getList()));
    }
    
    /**
     * Add new tag
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction() 
    {
        $this->processForm();
        
        $view = new ViewModel(array('form' => $this->form, 'title' => 'New tag'));
        $view->setTemplate('events/admin-tags/tag-form');
        return $view;
    }
    
    /*
     * public function editAction()
    {
        $I_dog = $this->getEntityFromQuerystring();
                
        // bind entity values to form
        $this->I_form->bind($I_dog);
        
        $I_view = new ViewModel(array('form' => $this->I_form, 'title' => 'Edit dog'));
        $I_view->setTemplate('mva-module-template/index/dog-form');
        return $I_view;
    }*/
    
    public function removeAction()
    {
        
        $I_tag = $this->getTagFromQuerystring();
        
        $this->tagService->removeTag($I_tag);
        
        return $this->redirect()->toRoute('zfcadmin/tags');
        
    }
    
    
    /*
     * Private methods
     */
    
    private function processForm() {
        
        if ($this->request->isPost()) {
        
            $tag = $this->getTagFromQuerystring(true);
            
            // bind entity values to form
            if ($tag instanceof \Events\Entity\Tag) {
                $this->form->bind($tag);
                $confirmMessage = 'Tag ' . $tag->getName() . ' updated successfully';
            } else {
                $confirmMessage = 'Tag inserted successfully';
            }
            
            // get post data
            $post = $this->request->getPost()->toArray();
                        
            // fill form
            $this->form->setData($post);
        
            // check if form is valid
            if(!$this->form->isValid()) {
        
                // prepare view
                $view = new ViewModel(array('form'  => $this->form,
                                              'title' => 'Some errors during tag processing'));
                $view->setTemplate('events/admin-tags/tag-form');
                return $view;
        
            }
        
            // use service to save data
            $tag = $this->tagService->upsertTagFromArray($this->form->getData());
        
            $this->flashMessenger()->setNamespace('admin-tag')->addMessage($confirmMessage);
            
            // redirect to tag list
            return $this->redirect()->toRoute('zfcadmin/tags');
            
        }
                
    }
    
    private function getTagFromQuerystring($allowNull = false) {
    
        $id = (int)$this->params('id');
    
        if (empty($id) || $id <= 0){
            $this->getResponse()->setStatusCode(404);    //@todo there is a better way?
            // Probably triggering Not Found Event SM
            // Zend\Mvc\Application: dispatch.error
            return;
        }
    
        $tag = $this->tagService->getTag($id);
    
        if (!$allowNull) {
            if ($tag === null){
                throw new \Exception('Tag not found');    //@todo throw custom exception type
            }
        }
    
        return $tag;
    
    }
    
}
