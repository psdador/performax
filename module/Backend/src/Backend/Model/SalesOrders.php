<?php

namespace Backend\Model;
use Zend\Validator;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;

class SalesOrders
{

    use FetchTrait;

    private $_collectionName = 'sales_orders';
    private $_collection = NULL;
    private $_variantModel = NULL;
    private $_sequenceModel = NULL;

    public function setVariantModel($variantModel)
    {
        $this->_variantModel = $variantModel;
    }

    public function setDbAdapter($dbAdapter)
    {
        $this->_collection = $dbAdapter->selectCollection($this->_collectionName);
    }

    public function setSequenceModel($sequenceModel)
    {
        $this->_sequenceModel = $sequenceModel;
    }


    public function salesOrder($order){
        unset($order['q']);

        $shipmentDate = strtotime($order['shipmentDate']);

        $salesOrder = ['created'       => new \MongoDate(),
                       '_id'           => $this->_sequenceModel->getNextSequence('salesorder'),
                       'paid'          => FALSE,
                       'paid_date'     => NULL,
                       'shipped'       => FALSE,
                       'shipped_date'  => NULL,
                       'finalized'     => FALSE,
                       'customer'      => $order['customer'],
                       'deliveryAddr'  => $order['deliveryAddr'],
                       'shipmentDate'  => new \MongoDate($shipmentDate),
                       'deliveryTime'  => $order['deliveryTime'],
                       'phone'         => $order['phone'],
                       'seller'        => $order['seller'],
                       'deliveryType'  => $order['deliveryType'],
                       'paymentType'   => $order['paymentType'],
                       'rider'         => isset($order['rider'])? $order['rider']: '',
                       'note'          => isset($order['note'])? $order['note']: '',
                       'shippingfee'   => isset($order['shippingfee'])? $order['shippingfee']: 0.00,
                       'payments'      => []
        ];
        $total = 0;
        foreach($order['items'] as $key => $item){
            $salesOrder['items'][$key]['qty']      = (float) $item['qty'];
            $salesOrder['items'][$key]['price']    = (float) $item['price'];
            $salesOrder['items'][$key]['cost']     = (float) $item['cost'];
            $salesOrder['items'][$key]['discount'] = (float) $item['discount'];
            $salesOrder['items'][$key]['subtotal'] = (float) $item['subtotal'];
            $salesOrder['items'][$key]['sku']      = $item['sku'];
            $salesOrder['items'][$key]['id']       = $item['id'];
            $total += (float)$item['subtotal'];
            // $this->_variantModel->decrementVariantStock($item['id'], (float) $item['qty']);
        }


        if(isset($order['shippingfee']) && $order['shippingfee'] > 0){
          $total += $order['shippingfee'];
        }

        $salesOrder['total'] = $total;
        $salesOrder['payment_left'] = $total;
        $result = $this->_collection->insert($salesOrder);
        if(!empty($result['err'])){
            throw new \Exception($result['err']);
        }
        return $salesOrder['_id'];
    }


    public function updateSalesOrder($orderId, $order){
        unset($order['q']);

        $shipmentDate = strtotime($order['shipmentDate']);
        $salesOrder = ['updated'       => new \MongoDate(),
                       'customer'      => $order['customer'],
                       'deliveryAddr'  => $order['deliveryAddr'],
                       'shipmentDate'  => new \MongoDate($shipmentDate),
                       'deliveryTime'  => $order['deliveryTime'],
                       'phone'         => $order['phone'],
                       'seller'        => $order['seller'],
                       'deliveryType'  => $order['deliveryType'],
                       'paymentType'   => $order['paymentType'],
                       'rider'         => isset($order['rider'])? $order['rider']: '',
                       'note'          => isset($order['note'])? $order['note']: '',
                       'shippingfee'   => isset($order['shippingfee'])? $order['shippingfee']: 0.00,
        ];
        $total = 0;
        foreach($order['items'] as $key => $item){
            $salesOrder['items'][$key]['qty']      = (float) $item['qty'];
            $salesOrder['items'][$key]['cost']     = (float) $item['cost'];
            $salesOrder['items'][$key]['price']    = (float) $item['price'];
            $salesOrder['items'][$key]['discount'] = (float) $item['discount'];
            $salesOrder['items'][$key]['subtotal'] = (float) $item['subtotal'];
            $salesOrder['items'][$key]['sku']      = $item['sku'];
            $salesOrder['items'][$key]['id']       = $item['id'];
            $total += (float)$item['subtotal'];
        }

        if(isset($order['shippingfee']) && $order['shippingfee'] > 0){
          $total += $order['shippingfee'];
        }


        $salesOrder['total'] = $total;

        $criteria = ["_id" => (int) $orderId];
        $result = $this->_collection->update($criteria, ['$set' => $salesOrder]);
        if(!empty($result['err'])){
            throw new \Exception($result['err']);
        }
        return TRUE;
    }

    public function markAsPaid($id)
    {
        $criteria = ['_id' => (int) $id];

        $updateDate = ['$set' => ['paid' => TRUE, 'paid_date' => new \MongoDate()]];
        return $this->_collection->update($criteria, $updateDate);
    }

    public function pay($id, $data)
    {
        $criteria = ['_id' => (int) $id];
        $salesorder = $this->fetchOne($criteria);

        // compute payment left
        $payment = $data['paymenttobemade'];
        $paymentLeft = (float)$salesorder['payment_left'] - (float)$payment;

        // data to be updated
        $updateData['payment_left'] = $paymentLeft;
        $payment = ['payments' => ['amount' => $payment, 'paid' => new \Mongodate()]];

        // mark paid date if payment_left is now <= zero
        if($paymentLeft <= 0){
            $updateData['payment_left'] = 0; // force to zero
            $updateData['paid_date'] = new \MongoDate();
            $updateData['paid'] = TRUE;
        }

        // update
        return $this->_collection->update($criteria, ['$push' => $payment, '$set' => $updateData]);



    }

    public function finalize($id)
    {
        $criteria = ['_id' => (int) $id];

        $updateDate = ['$set' => ['finalized' => TRUE, 'finalized_date' => new \MongoDate()]];
        return $this->_collection->update($criteria, $updateDate);
    }

    public function markAsDelivered($id)
    {

        $criteria = ['_id' => (int) $id];

        $data = $this->_collection->findOne($criteria);

        foreach($data['items'] as $item)
        {
           $this->_variantModel->decrementVariantStock($item['id'], (float) $item['qty']);
        }

        $updateDate = ['$set' => ['shipped' => TRUE, 'shipped_date' => new \MongoDate()]];
        return $this->_collection->update($criteria, $updateDate);
    }





}