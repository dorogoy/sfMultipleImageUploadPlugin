<?php

abstract class PluginPhotosTable extends Doctrine_Table {

    public function getDefault($casa_id) {
        return $this->createQuery('c')
                ->andWhere('c.casa_id = ?', $casa_id)
                ->andWhere('c.is_default = ?', 1)
                ->fetchOne();
    }
}
