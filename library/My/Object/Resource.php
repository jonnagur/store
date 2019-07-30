<?php

class My_Object_Resource {

    private $resourceId;
    private $resourceName;
    private $resourceModule;

    public function setResourceId($resourceId) {
        $this->resourceId = $resourceId;
    }

    public function getResourceId() {
        return $this->resourceId;
    }

    public function setResourceName($resourceName) {
        $this->resourceName = $resourceName;
    }

    public function getResourceName() {
        return $this->resourceName;
    }

    public function setResourceModule($resourceModule) {
        $this->resourceModule = $resourceModule;
    }

    public function getResourceModule() {
        return $this->resourceModule;
    }

    public function populate($data) {
        if (isset($data["resourceId"]))
            $this->setResourceId($data["resourceId"]);
        if (isset($data["resourceName"]))
            $this->setResourceName($data["resourceName"]);
        if (isset($data["resourceModule"]))
            $this->setResourceModule($data["resourceModule"]);
        return $this;
    }

    public function toArray() {
        $data = array();
        if (isset($this->resourceId))
            $data ["resourceId"] = $this->getResourceId();
        if (isset($this->resourceName))
            $data ["resourceName"] = $this->getResourceName();
        if (isset($this->resourceModule))
            $data ["resourceModule"] = $this->getResourceModule();
        return $data;
    }

}

?>