<?php
// Dans cette interface on va définir deux propiétés
namespace App\Model;

interface StampInterface
{
    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAt(\DateTimeInterface $createdAt);

    public function getUpdatedAt(): ?\DateTimeInterface;

    public function setUpdatedAt(?\DateTimeInterface $updatedAt);

}