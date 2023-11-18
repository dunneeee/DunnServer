<?php

namespace DunnServer\Http;

use DunnServer\Utils\DunnArray;
use DunnServer\Utils\DunnFile;
use DunnServer\Utils\DunnMap;

/**
 * @extends DunnMap<DunnArray<DunnFile>>
 */
class FileUpload extends DunnMap
{
  function __construct()
  {
    parent::__construct();
    $this->setMap($this->getDataFormat()->toArray());
  }

  function getDataFormat()
  {
    /**
     * @var \DunnServer\Utils\DunnMap<\DunnServer\Utils\DunnArray<\DunnServer\Utils\DunnFile>>
     */
    $files = new DunnMap();
    foreach ($_FILES as $key => $value) {
      $temp = $value;
      if (!is_array($value['name'])) {
        $temp['name'] = [$value['name']];
        $temp['type'] = [$value['type']];
        $temp['tmp_name'] = [$value['tmp_name']];
        $temp['error'] = [$value['error']];
        $temp['size'] = [$value['size']];
      }

      /**
       * @var \DunnServer\Utils\DunnArray<\DunnServer\Utils\DunnFile>
       */
      $data = new DunnArray();
      for ($i = 0; $i < count($temp['name']); $i++) {
        $curFile = new DunnFile($temp['name'][$i], $temp['tmp_name'][$i], $temp['type'][$i], $temp['size'][$i], $temp['error'][$i]);
        $data->push($curFile);
      }
      $files->set($key, $data);
    }
    return $files;
  }
}
