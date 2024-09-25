<?php

class Post{
    public int $id;
    public string $titulo;
    public string $contenido;
    public string $descripcion;
    public string $autor;
    public DateTime $fecha_publicacion;
    public int $valoracion;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function getContenido(): string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): void
    {
        $this->contenido = $contenido;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }


    public function getAutor(): string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): void
    {
        $this->autor = $autor;
    }

    public function getFechaPublicacion(): DateTime
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(DateTime $fecha_publicacion): void
    {
        $this->fecha_publicacion = $fecha_publicacion;
    }

    public function getValoracion(): int
    {
        return $this->valoracion;
    }

    public function setValoracion(int $valoracion): void
    {
        $this->valoracion = $valoracion;
    }


}