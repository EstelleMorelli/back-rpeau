<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        return $medias = Media::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        // Extraction et sécurisation des valeurs passées dans le body de la requête
        $file = htmlspecialchars($request->input('file'), ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($request->input('description'), ENT_QUOTES, 'UTF-8');

        // Création d'une nouvelle instance Media
        $media = new Media();
        // Sauvegarde
        $media->file = $file;
        $media->description = $description;
        // Gestion de la réponse HTTP

        if ($media->save()){
            /* TODO DECOMMENTER QUAND LA TABLE PIVOT SERA PRETE
            // Vérification des catégories et ajout à la table pivot après sauvegarde du media
            if ($request->has('categories')) {
                $categories = $request->input('categories');  // Récupération des categories
                if (is_array($categories) && count($categories) > 0) {
                    // Attacher les categories
                    $media->categories()->attach($categories);
                }
            }*/
            return response()->json($media, Response::HTTP_CREATED);
        } 
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     */
    public function find(string $id)
    {
        return $medias = Media::findOrFail($id);
        //TODO remplacer par         return Media::with('categories')->findOrFail($id);         quand la table pivot sera prete
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    // Recherche du media en fonction de l'id
    $media = Media::findOrFail($id);
      // Mise à jour conditionnelle des champs avec sécurisation
     if ($request->has('file')) {
     $media->file = htmlspecialchars($request->input('file'), ENT_QUOTES, 'UTF-8');  // Protection contre les XSS
     }
     /* TODO VOIR SI EN DESSOUS CA SUFFIT
          if ($request->has('picture')) {
     // Validation URL déjà effectuée, pas besoin de nettoyage supplémentaire si l'URL est correcte
     $media->picture = $request->input('picture');
     }
     */
     if ($request->has('description')) {
     $media->description = htmlspecialchars($request->input('description'), ENT_QUOTES, 'UTF-8');  // Protection contre les XSS
     }

     // Mise à jour des categories (relation Many-to-Many)
     /* TODO A décommenter quand la table pivot sera prete
     if ($request->has('categories')) {
     $categories = $request->input('categories');  // Récupération des categories depuis la requête
     // Utilisation de la méthode sync() pour mettre à jour les categories associées à l'media
     $media->categories()->sync($categories);
     }
     */
     // Gestion de la réponse HTTP
     if ($media->save()){
         return response()->json($media);
     }
     return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        //Récupération du media en fonction de l'id
        $media = Media::findOrFail($id);
        // Suppression et gestion de la réponse HTTP
        if ($media->delete()){
            return response(null, Response::HTTP_NO_CONTENT);
        }
        return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);

    }
}
