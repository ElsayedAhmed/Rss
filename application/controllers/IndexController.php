<?php
class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Link();
        
    }

    public function indexAction()
    {
        $form = new Application_Form_Add();
        $this->view->form = $form;
        $links=$this->model->listLinks();
        $this->view->links = $links;
        
        $data = [];

        $edata = [];

        $arr = [];
        for($i = 0 ; $i < count($links) ; $i++) {
            $link=$links[$i]["link"];
            $feed = Zend_Feed_Reader::import($link);
            $data['title'] = $feed->getTitle();
            $data['link']= $feed->getLink();
            $data['dateModified'] = $feed->getDateModified();
            $data['description'] = $feed->getDescription();
            $data['language'] = $feed->getLanguage();
            $data['entries'] = array();

            foreach ($feed as $entry) {
                $edata['title'] = $entry->getTitle();
                $edata['description'] = $entry->getDescription();
                $edata['dateModified'] = $entry->getDateModified();
                $edata['authors'] = $entry->getAuthors();
                $edata['link'] = $entry->getLink();
                $edata['content'] = $entry->getContent();
                // ------------------------------------
                $data['entries'][] = $edata;
            } 
            array_push($arr,$data);
            // var_dump($arr);
        }
          
        $this->view->datay = $arr;
    }

    public function addAction()
    {
        // action body
        $form = new Application_Form_Add();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $link=trim($data["link"]);
                // $rss = new SimpleXmlElement($link);
                // if($rss)
                // {
                    $this->model->addLink($link);
                // }else{
                //     return false;
                // }
            }
        }
        $this->view->form = $form;
    }
}


