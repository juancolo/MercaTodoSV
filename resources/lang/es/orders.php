<?php

return [
  'view'=>[
      'index'=> [
          'page_title' => 'Order Administrator',
          'search' => 'Search orders'
      ],
      'table' => [
          'headers' =>[
              'references' => 'References',
              'total' => 'Total',
              'user_belongs' => 'User',
              'status' => 'Status'
          ],
          'empty' =>[
              'There is no orders to see'
          ]
      ]
  ]
];
