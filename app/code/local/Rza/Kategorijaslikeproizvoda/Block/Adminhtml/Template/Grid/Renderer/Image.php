<?php 
class Rza_Kategorijaslikeproizvoda_Block_Adminhtml_Template_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    } 
    protected function _getValueTHIS(Varien_Object $row)
    {
        $val = $row->getData($this->getColumn()->getIndex());
        $val = str_replace("no_selection", "", $val);
        $url = Mage::getBaseUrl('media') . 'catalog/product' . $val; 
        $out = "<img src=". $url ." width='70px'/>"; 
        return $out;
    }
    protected function _getValueTBT(Varien_Object $row)
    {
        $dored = false;
        if ($getter = $this->getColumn()->getGetter()) {
            $val = $row->$getter();
        }
        $val = $val2 = $row->getData($this->getColumn()->getIndex());
        $val = str_replace('no_selection', '', $val);
        $val2 = str_replace('no_selection', '', $val2);
        $url = Mage::helper('enhancedgrid')->getImageUrl($val);

        if (!Mage::helper('enhancedgrid')->getFileExists($val)) {
            $dored = true;
            $val .= '[!]';
        }
        if (strpos($val, 'placeholder/')) {
            $dored = true;
        }

        $filename = substr($val2, strrpos($val2, '/') + 1, strlen($val2) - strrpos($val2, '/') - 1);
        if (!self::$showImagesUrl) {
            $filename = '';
        }
        if ($dored) {
            $val = "<span style=\"color:red\" id=\"img\">$filename</span>";
        } else {
            $val = '<span>'.$filename.'</span>';
        }

        if (empty($val2)) {
            $out = '<center>'.$this->__('(no image)').'</center>';
        } else {
            $out = $val.'<center><a href="#" onclick="window.open(\''.$url.'\', \''.$val2.'\')"'.
            'title="'.$val2.'" '.' url="'.$url.'" id="imageurl">';
        }

        if (self::$showByDefault && !empty($val2)) {
            $out .= '<img src='.$url." width='".self::$width."' ";
            if (self::$height > self::$width) {
                $out .= "height='".self::$height."' ";
            }
            $out .= ' />';
        }
        //die( $this->helper('catalog/image')->init($_product, 'small_image')->resize(135, 135));
        $out .= '</a></center>';

        return $out;
    }
    protected function _getValue(Varien_Object $row) {
        $proizvod = Mage::getModel('catalog/product')->load($row->getData('entity_id'));
        $proizvodSlika = Mage::helper('catalog/image')->init($proizvod, 'image')->resize(80);
        $out = "<img src=". $proizvodSlika ." width='70px'/>"; 
        return $out;
    }
}