<?php
namespace Miniurl\Database;

interface StorageInterface
{
    public function store($hash,$url);
    public function getCount($hash);
    public function update();
    public function incCount($hash);
    public function getUrlByHash($hash);
    public function checkHash($hash);

}
