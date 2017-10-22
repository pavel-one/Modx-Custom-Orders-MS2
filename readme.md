Это дополнение к статье на [modx.pro](https://modx.pro/howto/13548-podgotavlivaya-lk-for-deposita/ "Перейти на сайт"), прежде чем делать что-то на своем проекте, прочитайте статью и не забывайте делать бэккапы, господа

![Внешний вид карточки](https://pavel.one/img/dont_delite/11.jpg)

# Установка

Первым делом копируем все файлы в корень сайта

## Добавляем поле заказа:

Добавляем новое поле в нашу базу данных в таблицу **modx_ms2_orders**. В консоле выполняем:

	$table = $modx->getTableName('msOrder');
	$sql = 'ALTER TABLE ' . $table . '  ADD `track` VARCHAR(255) NULL;';
	$modx->exec($sql);

Расширяем модель msOrder добавляя нашу карту:

	if ($miniShop2 = $modx->getService('miniShop2')) {
	    $miniShop2->addPlugin('orderCustomField', '{core_path}components/orderCustomField/index.php');
	}

Теперь modx и ms2 знают о нашем поле, но нужно добавить его в разметку, я добавил его сразу после поля "Оплата", для этого создадим новый плагин, назовем его к примеру **CustomOrdersField**, ставим галочку на событии **msOnManagerCustomCssJs**, ставим галочку на поле "Статичный" и выбираем файл по пути **core/components/orderCustomField/plugin.php** 

Теперь у нас должно появиться поле в заказе под названием "Трек - номер", вы можете использовать его полноценно как и любое другое поле minishop2, хоть в письмах, хоть на фронте сайта

## Красивый вывод заказов пользователя

### Требования к фронту сайта:

1. Jquery 
2. FontAwesome (не обязательно)  
3. FancyBox 3

### Установка

Нам нужно подключить сначала JS и CSS отвечающий за работу и оформление заказов

	<link rel="stylesheet" href="/assets/components/MyCustomOrders/css/customOrders.css">
	<script src="/assets/components/MyCustomOrders/js/customOrders.js"></script>

Теперь самое интересное, на странице, которая у вас отвечает за вывод заказов пользователю добавте чанк **getUserOrder**, и скопируйте в него содержимое файла **/assets/components/MyCustomOrders/chunk/chunk.tpl.html**

Код чанка **order_row**:

	<div class="item" data-id="{$id}">
	  <div class="top">
	    <div class="num">{$num}</div>
	    <div class="price">{$cost}</div>
	  </div>
	  <div class="middle">
	    <div class="status" style="color: #{$color}">{$statusName}</div>
	    <div class="date">{$createdon | dateAgo}</div>
	  </div>
	  <div class="bottom">
	    <div class="left">
	      Подробнее
	    </div>
	    <div class="right">
	      <i class="fa fa-angle-right" aria-hidden="true"></i>
	    </div>
	  </div>
	</div>

Вот собственно и все