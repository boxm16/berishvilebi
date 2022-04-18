<?php

require_once 'DAO/MapVersionDao.php';

class MapVersionController {

    public function getAllMapVersions() {
        $mapVersionDao = new MapVersionDao();
        return $mapVersionDao->getAllMapVersions();
    }

}
