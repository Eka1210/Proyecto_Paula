<?php 
namespace Model;

class ProductDecorator {
    public static function addOptionToProduct($productId, $optionData, $values) {
        $option = new Option(['name' => $optionData]);
        $datos = $option->guardar();
        $optionId = $datos['id'];
        $valuesJson = json_encode($values);

        $optionProduct = new OptionsXProduct([
            'productID' => $productId,
            'optionID' => $optionId,
            'value' => $valuesJson
        ]);
        $optionProduct->guardar();
        
    }
}
