<?php

namespace Domain\Product;

use DateTime;

class ProductFactory
{

    /**
     * Création d'un objet produit
     * @param string $category
     * @param array $params
     * @return Textile|Alimentaire|Electromenager
     * @throws \DateMalformedStringException
     */
    public function createProduct(string $category, array $params): Textile|Alimentaire|Electromenager
    {
        if(!$this->isAllowedCategory($category))
        {
            throw new \Exception("La catégorie sélectioner n'est pas valide");
        }

        $params = $this->filterAllowedParams($category,$params);

        $productClass = "\\Domain\\Product\\".ucfirst($category);

        if(!class_exists($productClass))
        {
            throw new \Exception("La catégorie n'existe pas");
        }

        // Produit alimentaire
        if($category == "Alimentaire")
        {
            // Vérification de la dlc
            $params['dateExpiration'] = new DateTime($params['dateExpiration']);
        }

        // Produit éléctroménager
        if ($category === "Electromenager")
        {
            $params['guarantee'] = new DateTime($params['guarantee']);
        }

        // Création de l'objet
        return new $productClass(...$params);
    }

    /**
     * Vérifier la catégorie soumis
     * @param string $category
     * @return bool
     */
    private function isAllowedCategory(string $category): bool
    {
        $allowedCategories = ["Electromenager", "Textile", "Alimentaire"];
        return in_array($category, $allowedCategories);
    }

    /**
     * Filtre les paramètres
     * @param array $params
     * @return array
     */
    private function filterAllowedParams(string $category, array $params): array
    {
        switch ($category)
        {
            case "Alimentaire":
                $allowedParams = ["name", "price", "quantity", "dateExpiration"];
                break;
            case "Electromenager":
                $allowedParams = ["name", "price", "guarantee", "quantity"];
                break;
            case "Textile":
                $allowedParams = ["name", "price", "size", "quantity"];
                break;
        }

        return array_filter($params, function ($key) use ($allowedParams) {
            return in_array($key, $allowedParams);
        }, ARRAY_FILTER_USE_KEY);
    }
}