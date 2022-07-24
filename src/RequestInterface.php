<?php

namespace Szwtdl\Paypal;

interface RequestInterface
{
    public function setMethod(string $method);

    public function getMethod();

    public function setParams(array $params);

    public function getParams();

    public function setPath(string $path);

    public function getPath();

}