<?php

class Comments{
    public int $id_comentario;
    public int $id_post;
    public string $nombreComentador;
    public string $contenido;

    public function getIdComentario(): int
    {
        return $this->id_comentario;
    }

    public function setIdComentario(int $id_comentario): void
    {
        $this->id_comentario = $id_comentario;
    }

    public function getIdPost(): int
    {
        return $this->id_post;
    }

    public function setIdPost(int $id_post): void
    {
        $this->id_post = $id_post;
    }

    public function getNombreComentador(): string
    {
        return $this->nombreComentador;
    }

    public function setNombreComentador(string $nombreComentador): void
    {
        $this->nombreComentador = $nombreComentador;
    }

    public function getContenido(): string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): void
    {
        $this->contenido = $contenido;
    }


}