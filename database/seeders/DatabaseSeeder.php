<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\Direccion;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Libro;
use App\Models\Pedido;
use App\Models\Post;
use App\Models\Provincia;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(30)->create();
        Libro::factory(30)->create();
        Provincia::factory(30)->create();
        Direccion::factory(30)->create();
        Pedido::factory(30)->create();
        $categoria = new Categoria();
        $categoria->nombre = "Lectura digital";
        $categoria->slug = "lectura-digital";
        $categoria->save();

        $categoria = new Categoria();
        $categoria->nombre = "Eventos";
        $categoria->slug = "eventos";
        $categoria->save();

        $categoria = new Categoria();
        $categoria->nombre = "Noticias literarias";
        $categoria->slug = "noticias-literarias";
        $categoria->save(); 
        
        $categoria = new Categoria();
        $categoria->nombre = "Recomendados";
        $categoria->slug = "recomendados";
        $categoria->save();


        Post::factory(30)->create();
        Comentario::factory(30)->create();
        
        $libros=Libro::all();
        foreach ($libros as $libro) {
            if (strpos($libro->portada, "public/")!="") {
                $libro->portada=str_replace(["public/"], "", $libro->portada);
                $libro->save();
            }
        }
    }
}
