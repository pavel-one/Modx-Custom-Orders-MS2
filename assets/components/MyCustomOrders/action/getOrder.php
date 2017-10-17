<?php
define('MODX_API_MODE', true);
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/index.php';

$modx->getService('error','error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
  	$modx->sendRedirect($modx->makeUrl($modx->getOption('site_start'),'','','full'));
}
$order_id = $_POST['id'];
$pdoFetch = $modx->getService('pdoFetch');
$pdoFetch->setConfig(array(
  'class' => 'msOrder',
  'sortby' => 'createdon',
  'return' => 'data',
  'leftJoin' => array(
    'msDelivery' => array(
      'class' => 'msDelivery',
      'on' => 'msDelivery.id = msOrder.delivery'
      ),
    'msOrderStatus' => array(
      'class' => 'msOrderStatus',
      'on' => 'msOrderStatus.id = msOrder.status'
      ),
    'msPayment' => array(
      'class' => 'msPayment',
      'on' => 'msPayment.id = msOrder.payment'
      ),
    'msOrderAddress' => array(
      'class' => 'msOrderAddress',
      'on' => 'msOrderAddress.id = msOrder.id'
      )
    ),
    'select' => array(
      'msOrder' => '*',
      'msDelivery' => 'msDelivery.name as deliveryName',
      'msOrderStatus' => 'msOrderStatus.name as statusName',
      'msPayment' => 'msPayment.name as paymentName',
      'msOrderAddress' => '*'
      ),
    'where' => array(
      'msOrder.user_id' => $modx->user->get('id'),
      'msOrder.id' => $order_id
      ),
    'tpl' => ''
  ));

$order = $pdoFetch->run();
$pdoFetch->setConfig(array(
  'class' => 'msOrderProduct',
  'sortby' => 'id',
  'return' => 'data',
  'where' => array(
    'order_id' => $order_id
    ),
  'tpl' => ''
  ));
$products = $pdoFetch->run();
$out = array(
	'order' => $order,
	'products' => $products
);

echo(json_encode($out));

?>