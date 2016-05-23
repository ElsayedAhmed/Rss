<?php
class Application_Model_DbTable_Link extends Zend_Db_Table_Abstract {

    protected $_name = 'links';

    function addLink($link) {
        $row = $this->createRow();
        $row->link = $link;
        return $row->save();
    }

    function listLinks() {
        return $this->fetchAll()->toArray();
    }
}
