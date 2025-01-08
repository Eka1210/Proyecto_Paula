<?php 
namespace Model;

class ProductDecorator extends ActiveRecord{
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

    public static function updateOption($id, $name, $values) {
    $option = Option::find($id);
    $option->name = $name;
    $option->guardar(); 

    $valuesJson = json_encode($values);
    $query = "UPDATE optionsxproduct SET value = '$valuesJson' WHERE optionID = $id";
    
    $resultado = self::$db->query($query);
    return $resultado;
}


}
