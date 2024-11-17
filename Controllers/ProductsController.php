<?php
namespace Controllers;

use Domain\Product\Alimentaire;
use Domain\Product\ProductFactory;
use Infra\Orm\ProductOrm;

class ProductsController extends Controller
{
    protected ProductOrm $productOrm;

    public function __construct()
    {
        $this->productOrm = new ProductOrm();
        parent::__construct();
    }

    public function index(): void
    {
        $products = $this->productOrm->getAll();

        $this->display('products/index.html.twig', [
            'products' => $products
        ]);
    }

    public function details(string $productId): void
    {
        $product = $this->productOrm->get($productId);

        $this->display('products/details.html.twig', [
            'product' => $product
        ]);
    }

    public function create(): void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // Formulaire soumis
            if(!isset($_POST['category']))
            {
                throw new \Exception("Vous devez sélectionner une catégorie");
            }

            $category = $_POST['category'];

            // Création de l'objet produit
            $factory = new ProductFactory();
            $product = $factory->createProduct($category, $_POST);

            $productInsertion = $this->productOrm->insert($product);

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
}