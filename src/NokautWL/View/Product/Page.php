<?php
namespace NokautWL\View\Product;

use Nokaut\ApiKit\ClientApi\Rest\Exception\NotFoundException;
use Nokaut\ApiKit\Collection\Offers;
use Nokaut\ApiKit\Entity\Product;
use NokautWL\ApiKitFactory;
use NokautWL\Routing\ProductsUrl;
use NokautWL\Routing\Routing;
use NokautWL\Template\Renderer;

class Page
{
    public static $products = array();

    /**
     * @return Product
     */
    public static function getProduct()
    {
        $nokautProductUrl = Routing::getNokautProductUrl();

        $key = md5($nokautProductUrl);
        if (isset(self::$products[$key])) {
            return self::$products[$key];
        }

        $apiKit = ApiKitFactory::getApiKit();
        $productRepository = $apiKit->getProductsRepository();
        try {
            $product = $productRepository->fetchProductByUrl($nokautProductUrl, $productRepository::$fieldsForProductPage);

            if (!Routing::isCategoryEnabled($product->getCategoryId())) {
                throw new NotFoundException();
            }

            self::$products[$key] = $product;
        } catch (NotFoundException $e) {
            self::$products[$key] = null;
        }

        return self::$products[$key];
    }

    public static function canonical()
    {
        $product = self::getProduct();

        if ($product === null) {
            return '';
        }

        $canonical = $product->getUrl();
        if ($canonical) {
            $canonical = ProductsUrl::productUrl($canonical);
        }

        return $canonical;
    }

    public static function noIndex()
    {
        $product = self::getProduct();

        if ($product === null) {
            return true;
        }
    }

    public static function title()
    {
        $product = self::getProduct();

        if ($product === null) {
            return '';
        }

        return $product->getTitle();
    }

    public static function render()
    {
        $product = self::getProduct();

        if ($product === null) {
            return Renderer::render('product/not-found.twig', array());
        }

        try {
            $apiKit = ApiKitFactory::getApiKit();
            $offersRepository = $apiKit->getOffersRepository();
            $offers = $offersRepository->fetchOffersByProductId($product->getId(), $offersRepository::$fieldsForProductPage);
        } catch (\Exception $e) {
            $offers = new Offers(array());
        }

        $breadcrumbLinks = Routing::getBreadcrumbLinks($product->getCategoryId());

        return Renderer::render('product/page.twig',
            array('product' => $product, 'offers' => $offers, 'breadcrumbLinks' => $breadcrumbLinks)
        );
    }
}
