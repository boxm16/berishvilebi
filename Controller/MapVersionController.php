<?php

require_once 'DAO/MapVersionDao.php';

class MapVersionController {

    public function getAllMapVersions() {
        $mapVersionDao = new MapVersionDao();
        return $mapVersionDao->getAllMapVersions();
    }

    public function getMapVersion($mapVersionId) {
        $mapVersionDao = new MapVersionDao();
        return $mapVersionDao->getMapVersion($mapVersionId);
    }

}
