<?php

namespace Model;

use Model\Sale;
use Model\Usuario;
use Model\Client;
use Model\Product;
use Model\Productxsale;
use Model\PaymentMethod;
use Model\DeliveryMethod;



class Report implements ReportInterface
{
    public function getReport($startDate, $endDate)
    {
        $sales = Sale::getSales($startDate, $endDate);
        $formattedData = [];

        foreach ($sales as $sale) {
            $user = client::find($sale->userId);
            $paymentMethod = PaymentMethod::find($sale->paymentMethodId);
            $deliveryMethod = DeliveryMethod::find($sale->deliveryMethodId);

            $productsxsale = Productxsale::whereAll('salesID', $sale->id);
            $productsDetail = [];

            foreach ($productsxsale as $pxs) {
                $product = Product::find($pxs->productID);
                $productsDetail[] = sprintf(
                    "%s (Cantidad: %d Total: ₡%s)",
                    $product->name,
                    $pxs->quantity,
                    number_format($pxs->price, 2, '.', ',')
                );
            }

            $formattedData[] = [
                $sale->id,
                $sale->descripcion,
                '₡' . number_format($sale->monto, 2),
                date('Y-m-d H:i', strtotime($sale->fecha)),
                '₡' . number_format($sale->discount, 2),
                $user->name,
                $paymentMethod->name,
                $deliveryMethod->name,
                '₡' . number_format($sale->deliveryCost, 2),
                implode("\n", $productsDetail),
            ];
        }

        return $formattedData;
    }
}
