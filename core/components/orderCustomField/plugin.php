<?php
switch ($modx->event->name) {
    case 'msOnManagerCustomCssJs':
        if ($page != 'orders') return;
	          $modx->controller->addHtml("
            <script type='text/javascript'>
                Ext.ComponentMgr.onAvailable('minishop2-window-order-update', function(){
                    this.fields.items[0].items[3].items[0].items.push(
                            {xtype: 'textfield', name: 'track', fieldLabel: 'Трек - номер', anchor: '100%'}
                        );     
                });           
            </script>");
    break;
}