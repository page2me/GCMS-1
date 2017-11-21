<?php
/**
 * @filesource modules/index/controllers/export.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Index\Export;

use \Kotchasan\Http\Request;
use \Kotchasan\Template;

/**
 * Controller สำหรับการ Export หรือ Print
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Kotchasan\Controller
{

  /**
   * export.php
   *
   * @param Request $request
   */
  public function index(Request $request)
  {
    // ตัวแปรป้องกันการเรียกหน้าเพจโดยตรง
    define('MAIN_INIT', 'export');
    // session cookie
    $request->initSession();
    // template ที่กำลังใช้งานอยู่
    if (!empty($_SESSION['skin']) && is_file(APP_PATH.'skin/'.$_SESSION['skin'].'/style.css')) {
      self::$cfg->skin = $_SESSION['skin'];
    }
    Template::init('skin/'.self::$cfg->skin);
    // ตรวจสอบโมดูลที่เรียก
    $index = \Index\Module\Model::getModuleWithConfig('', $request->get('module')->filter('a-z0-9'));
    if ($index) {
      $className = ucfirst($index->owner).'\Export\Controller';
      if (class_exists($className) && method_exists($className, 'init')) {
        $detail = createClass($className)->init($request, $index);
      } else {
        $detail = false;
      }
      if ($detail !== false) {
        if ($detail !== '') {
          $view = new \Gcms\View;
          $view->setContents(array(
            '/{CONTENT}/' => $detail
          ));
          echo $view->renderHTML(Template::load('', '', 'print'));
        }
        exit;
      }
    }
    // ไม่พบโมดูลหรือไม่มีสิทธิ
    new \Kotchasan\Http\NotFound();
  }
}