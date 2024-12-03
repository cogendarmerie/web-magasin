<?php
namespace Controllers;

use Domain\Product\Alimentaire;
use Domain\Product\ProductFactory;
use Infra\Database\ProduitRepository;
use Infra\Factory\ProduitFactory;
use Infra\Orm\ProductOrm;

class ProductsController extends AbstractController
{
    protected ProductOrm $productOrm;
    protected ProduitRepository $produitRepository;

    public function __construct()
    {
        $this->productOrm = new ProductOrm();
        $this->produitRepository = new ProduitRepository();
        parent::__construct();
    }

    public function index(): void
    {
        $products = $this->produitRepository->findAll();

        $this->display('products/index.html.twig', [
            'products' => $products
        ]);
    }

    public function details(string $productId): void
    {
        $product = $this->produitRepository->findOneById($productId);

        $this->display('products/details.html.twig', [
            'product' => $product
        ]);
    }

    public function create(): void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // Formulaire soumis
            if(!isset($_POST['categorie']))
            {
                throw new \Exception("Vous devez sélectionner une catégorie");
            }

            // Création de l'objet produit
            $product = ProduitFactory::create(...$_POST);
            $productInsertion = $this->produitRepository->insert($product);

            // Résultat de l'opération
            if($productInsertion)
            {
                $this->redirect('/products');
            }
            else
            {
                echo "Une erreur est survenue lors de l'enregistrement";
                exit();
            }
        }

        $this->display('products/create.html.twig', [
            "categories" => [
                [
                    "value" => "",
                    "text" => "--Sélectionner une catégorie--"
                ],
                [
                    "value" => "Electromenager",
                    "text" => "Electromenager"
                ],
                [
                    "value" => "Textile",
                    "text" => "Textile"
                ],
                [
                    "value" => "Alimentaire",
                    "text" => "Alimentaire"
                ]
            ]
        ]);
    }

    public function delete(): void
    {
        // Récupérer l'id du produit dans l'URL
        $productId = $_GET['productId'];

        // Supprimer le produit dans la BDD
        $deletion = $this->produitRepository->delete($productId);

        if($deletion)
        {
            $this->redirect('/products');
        }
        else
        {
            echo "Une erreur est survenue lors de la suppression";
        }
    }
}