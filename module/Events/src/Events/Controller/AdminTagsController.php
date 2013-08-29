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
     * Add a new tag
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction() 
    {
        
        $view = $this->processForm(null);
        
        if (!$view instanceof ViewModel) {
            
            $view = new ViewModel(array('form' => $this->form, 
                                        'title' => 'New tag'));
            $view->setTemplate('events/admin-tags/tag-form');
            
        }
        
        return $view;
        
    }
    
    /**
     * Edit an existing tag
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        
        $tag = $this->getTagFromQuerystring();
        
        $view = $this->processForm($tag);
                
        // bind tag values to form
        $this->form->bind($tag);
        
        if (!$view instanceof ViewModel) {

            $view = new ViewModel(array('form' => $this->form, 
                                        'title' => 'Edit tag ' . $tag->getName()));
            $view->setTemplate('events/admin-tags/tag-form');
            
        }
        
        return $view;
        
    }
    
    /**
     * Delete a tag
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function removeAction()
    {
        
        $tag = $this->getTagFromQuerystring();
        
        $this->tagService->removeTag($tag);
        
        return $this->redirect()->toRoute('zfcadmin/tags');
        
    }
    
    
    /*
     * Private methods
     */
    
    private function processForm(\Events\Entity\Tag $tag = null) {
        
        if ($this->request->isPost()) {
            
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
                //$view = new ViewModel();
                $view->setTemplate('events/admin-tags/tag-form');
                
                return $view;
        
            }
            
            // use service to save data
            $this->tagService->upsertTag($this->form->getData());
        
            $this->flashMessenger()->setNamespace('admin-tag')->addMessage($confirmMessage);
            
            // redirect to tag list
            return $this->redirect()->toRoute('zfcadmin/tags');
            
        }
                
    }
    
    private function getTagFromQuerystring() {
    
        $id = (int)$this->params('id');
    
        if (empty($id) || $id <= 0){
            $this->getResponse()->setStatusCode(404);    //@todo there is a better way?
            // Probably triggering Not Found Event SM
            // Zend\Mvc\Application: dispatch.error
            return;
        }
    
        $tag = $this->tagService->getTag($id);
    
        if ($tag === null){
            throw new \Exception('Tag not found');    //@todo throw custom exception type
        }

        return $tag;
    
    }
    
}
