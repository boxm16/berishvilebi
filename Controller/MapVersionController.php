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

    public function changeMapWidth($mapVersionId, $mapWidth) {
        $mapVersionDao = new MapVersionDao();
        $mapVersionDao->changeMapWidth($mapVersionId, $mapWidth);
    }

    public function changeMapHeight($mapVersionId, $mapHeight) {
        $mapVersionDao = new MapVersionDao();
        $mapVersionDao->changeMapHeight($mapVersionId, $mapHeight);
    }

}
