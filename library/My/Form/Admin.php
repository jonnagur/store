<?php

class My_Form_Admin extends My_Form {
    
    public function init(){
        parent::init();
        $this->setAttrib("class", "form");
    }
    
    public function addSaveButton(){
        $submit = new Zend_Form_Element_Submit("save");
        $submit->setLabel("Save");
        $this->addElement($submit);
    }
}
