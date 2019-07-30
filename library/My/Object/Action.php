<?php

class My_Object_Action {

    private $actionId;
    private $actionName;
    private $resourceId;

    public function setActionId($actionId) {
        $this->actionId = $actionId;
    }

    public function getActionId() {
        return $this->actionId;
    }

    public function setActionName($actionName) {
        $this->actionName = $actionName;
    }

    public function getActionName() {
        return $this->actionName;
    }

    public function setResourceId($resourceId) {
        $this->resourceId = $resourceId;
    }

    public function getResourceId() {
        return $this->resourceId;
    }

    public function populate($data) {
        if (isset($data["actionId"]))
            $this->setActionId($data["actionId"]);
        if (isset($data["actionName"]))
            $this->setActionName($data["actionName"]);
        if (isset($data["resourceId"]))
            $this->setResourceId($data["resourceId"]);
        return $this;
    }

    public function toArray() {
        $data = array();
        if (isset($this->actionId))
            $data ["actionId"] = $this->getActionId();
        if (isset($this->actionName))
            $data ["actionName"] = $this->getActionName();
        if (isset($this->resourceId))
            $data ["resourceId"] = $this->getResourceId();
        return $data;
    }

}

?>