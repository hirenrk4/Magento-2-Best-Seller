<?php
    namespace Hiren\BestsellerFilter\Block\Product\ProductList;

    class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
    {
        public function setCollection($collection)
        {
            if($this->getCurrentOrder()=="bestseller")
            {
                  $collection->getSelect()->joinLeft( 
                    'sales_order_item', 
                    'e.entity_id = sales_order_item.product_id', 
                    array('qty_ordered'=>'SUM(sales_order_item.qty_ordered)')) 
                    ->group('e.entity_id') 
                    ->order('qty_ordered '.$this->getCurrentDirectionReverse());
            }

            $this->_collection = $collection;

            $this->_collection->setCurPage($this->getCurrentPage());

            $limit = (int)$this->getLimit();
            if ($limit) {
                $this->_collection->setPageSize($limit);
            }
            if ($this->getCurrentOrder()) {
                $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
            }
            return $this;
        }

        public function getCurrentDirectionReverse() {
                if ($this->getCurrentDirection() == 'asc') {
                    return 'desc';
                } elseif ($this->getCurrentDirection() == 'desc') {
                    return 'asc';
                } else {
                    return $this->getCurrentDirection();
                }
            }

    }
?>
