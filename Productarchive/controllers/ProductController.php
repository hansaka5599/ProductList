<?php
require_once 'Mage/Catalog/controllers/ProductController.php';

/**
 * Class Ecommistry_Productarchive_ProductController
 */
class Ecommistry_Productarchive_ProductController extends Mage_Catalog_ProductController
{
    public function viewAction()
    {
        //Fetching initial data from request
        $categoryId     =   (int)$this->getRequest()->getParam('category', false);
        $productId      =   (int)$this->getRequest()->getParam('id');
        $specifyOptions =   $this->getRequest()->getParam('options');

        $viewHelper = Mage::helper('catalog/product_view');

        $params = new Varien_Object();
        $params->setCategoryId($categoryId);
        $params->setSpecifyOptions($specifyOptions);

        //Try to render page
        try {
            $viewHelper->prepareAndRender($productId, $this, $params);
        } catch (Exception $e) {
            if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
                if (isset($_GET['store']) && !$this->getResponse()->isRedirect()) {
                    $this->_redirect('');
                }
                elseif (!$this->getResponse()->isRedirect() && $productId) {
                    //Archive process
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $isArchive = $product->getArchive();

                    if ($isArchive) {
                        if ($product->getUrlToRedirectTo()) {
                            $url = $product->getUrlToRedirectTo();
                        }
                        else {
                            $categoryIds = $product->getCategoryIds();
                            if (is_array($categoryIds)) {
                                foreach ($categoryIds as $categoryId) {
                                    $category = $categoryId ? Mage::getModel('catalog/category')->load($categoryId) : '';
                                    $url = $category->getIsActive() ? $category->getUrl() : '';
                                    if ($url) {
                                        break;
                                    }
                                }
                            }
                        }

                        if ($url) {
                            $this->getResponse()->setRedirect($url, 301)->sendResponse();
                        }
                        else {
                            $this->getResponse()->setRedirect('/', 301)->sendResponse();
                        }
                    }
                    else {
                        $this->getResponse()->setRedirect('/', 410)->sendResponse();
                    }
                }
                else {
                    $this->_forward('noRoute');
                }
            }
            else {
                Mage::logException($e);
                $this->_forward('noRoute');
            }
        }
    }

}