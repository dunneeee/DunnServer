<?php

namespace DunnServer\Middlewares;

use DunnServer\Utils\DunnFile;

class HandleFileFilter implements Filter
{

  protected $dir;
  protected $publicDir;
  function __construct($dir = null, $publicDir = null)
  {
    $this->dir = $dir ?? $_SERVER['DOCUMENT_ROOT'];
    $this->publicDir = $publicDir ?? '/';
  }

  function doFilter($req, $res, $chain)
  {
    $req->setParams('_uploadRoot', $this->dir);
    $upload = $req->getUploads();
    $keys = $upload->keys()->toArray();
    foreach ($keys as $key) {
      $files = $upload->get($key);
      if ($files) {
        $files->forEach(function (DunnFile &$file) {
          $path = $this->dir . '/' . $file->getName();
          if (file_exists($path)) {
            $newName = time() . '_' . $file->getName();
            $path = $this->dir . '/' . $newName;
            $file->setName($newName);
          }
          $file->moveUploadFileTo($path);
          $file->setPath($this->publicDir . '/' . $file->getName());
        });
      }
    }
    $chain->doFilter($req, $res);
  }
}
