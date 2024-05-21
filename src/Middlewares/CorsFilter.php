<?php 

namespace DunnServer\Middlewares;

class CorsFilter implements Filter {
    function doFilter($req, $res, $chain)
    {
        $res->setHeader('Access-Control-Allow-Origin', '*');
        $res->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        $res->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $res->setHeader('Access-Control-Max-Age', '3600');
        $chain->doFilter($req, $res);
    }
}