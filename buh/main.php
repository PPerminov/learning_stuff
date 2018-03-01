<?php
namespace main;

use main\web\tag_double;
use main\web\tag_simple;
use main\web\tag;
use main\web\topMenuBuider;

require 'db/database.php';
require 'web/web_construct_base.php';
require 'web/web_construct.php';

switch ($_GET['page']) {
  case 'account':
    echo web\topMenuBuider() . web\accountBuilder();
    break;
    case 'spend':
    echo web\topMenuBuider() . web\spendBuilder();
          break;
      case 'income':
         echo web\topMenuBuider() . web\incomeBuilder();
        break;
        case 'db':
          echo web\topMenuBuider() . web\db();
          break;
  default:
echo web\topMenuBuider();
    break;
}



//
// if ($_GET['page'] == "account") {
//     echo web\topMenuBuider() . web\accountBuilder();
// } elseif (($_GET['page'] == "spend")) {
//     echo web\topMenuBuider() . web\spendBuilder();
// } elseif (($_GET['page'] == "income")) {
//     echo web\topMenuBuider() . web\incomeBuilder();
// } else {
//     echo web\topMenuBuider();
// }
//
//   // echo web\topMenuBuider() . web\accountBuilder();
