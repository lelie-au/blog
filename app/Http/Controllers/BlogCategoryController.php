<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\APIError;

class BlogCategoryController extends Controller
{
      //fonction pour lister les elements de la table catégories
        public function index(Request $request){

            $data = BlogCategory::simplePaginate($request->has('limit') ? $request->limit : 15);
            return response()->json($data);
        }

       // fontion permettant d'ajouter un elemrnt dans la table catégorie 
        public function create(Request $request)
        {

            $this->validate($request->all(), 
            [
                'name'=>'required' // champ obligatoire
            ]);

            $data = [];
            $data = array_merge($data, $request->only(
            [
                'name',
                'description'
            ]));
            
            $blogcategory = BlogCategory::create($data);

            return response()->json($blogcategory);
        }

        public function update(Request $request, $id)
        {

             $blogcategory = BlogCategory::find($id);
                if (!$blogcategory) {

                    $error = new APIError;
                    $error-> setStatuts("404");
                    $error-> setCode("blogcatogory not found");
                    $error-> setMessage("l'id n'existe pas");
                    return  response()->json($error);
                }
           
           $data = [];
            $data = array_merge($data, $request->only([
                'name',
                'description'
            ]));
            
            $blogcategory->name = $data['name'];
            $blogcategory->description = $data['description'];
            $blogcategory->update();

            return response()->json($blogcategory);
        }


        public function find($id)
        {
            $blogcategory = BlogCategory::find($id);
            if (!$blogcategory) {
                $error = new APIError;
                $error-> setStatuts("404");
                $error-> setCode("blogcatogory not found");
                $error-> setMessage("l'id n'existe pas");
                return  response()->json($error);
            }
            return response()->json($blogcategory);
            
        }

        public function delete($id)
        {
            $blogcategory = BlogCategory::find($id);
            if (!$blogcategory) {

                $error = new APIError;
                $error-> setStatuts("404");
                $error-> setCode("blogcatogory not found");
                $error-> setMessage("l'id n'existe pas");
                return  response()->json($error);
            }
            $blogcategory->delete();
            return response()->json();
            
        }

}

