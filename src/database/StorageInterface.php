<?php
namespace Miniurl\Database;

interface StorageInterface
{
    public function store(string $hash, string $url);
    public function getCount(string $hash);
    public function update();
    public function incCount(string $hash);
    public function getUrlByHash(string $hash);
    public function checkHash(string $hash);

}
