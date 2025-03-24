<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProduitRequest;
use App\Http\Requests\CreateProduitRequest;
use App\Models\Produit;
use Illuminate\Http\Request;
use Exception;

class ProduitController extends Controller
{
    public function index()
    {
        try{
            $produits = Produit::all();
            return response()->json([
                'success' => true,
                'produits' => $produits
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des produits',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    

    public function store(CreateProduitRequest $request)
{
    $produit = new Produit();
    $produit->nom = $request->nom;
    $produit->description = $request->description;
    $produit->prix = $request->prix;
    
    // Traitement de l'image AVANT de sauvegarder

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('produits', 'public');
        $produit->image = $imagePath;
    }
    // Placer ce code AVANT $produit->save();
    
    $produit->save();
    
    return response()->json([
        'success' => true,
        'message' => 'produit ajouté avec succès',
        'produit' => $produit
    ], 201);
}


public function update(EditProduitRequest $request, $id) {
    // Recherche du produit dans la base de données par son ID
    $produit = Produit::find($id);
    
    // Vérification si le produit existe
    if (!$produit) {
        // Si le produit n'existe pas, retourne une réponse JSON avec un code 404 (Not Found)
        return response()->json([
            'success' => false,
            'message' => 'Produit non trouvé'
        ], 404);
    }
    
    // Mise à jour des propriétés du produit avec les valeurs de la requête
    $produit->nom = $request->nom;               // Met à jour le nom du produit
    $produit->description = $request->description; // Met à jour la description du produit
    $produit->prix = $request->prix;             // Met à jour le prix du produit
    
    // Vérification si la requête contient un fichier image
    if ($request->hasFile('image')) {
        // Si oui, stocke l'image dans le dossier 'public/produits'
        // et récupère le chemin pour l'enregistrer dans la base de données
        $imagePath = $request->file('image')->store('produits', 'public');
        $produit->image = $imagePath;            // Met à jour le chemin de l'image
    }
    
    // Sauvegarde les modifications dans la base de données
    $produit->save();
    
    // Retourne une réponse JSON avec un message de succès et le produit mis à jour
    return response()->json([
        'success' => true,
        'message' => 'Produit modifié avec succès',
        'produit' => $produit                    // Inclut les données du produit mise à jour dans la réponse
    ], 200);                                     // Code HTTP 200 indiquant que tout s'est bien passé
}

public function delete(Produit $produit)
{
    try {
        $produit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produit supprimé avec succès'
        ], 200);

    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la suppression',
            'error' => $e->getMessage()
        ], 500);
    }
}

    
   }
