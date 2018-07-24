<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/23
 * Time: 11:46
 */

namespace app\admin\controller;


use app\common\builder\ZBuilder;
use app\admin\model\Model;
use app\admin\model\Field as FieldModel;
use think\Db;
use think\Request;

class Fieldclass extends Admin
{

  public function index(){
      return $this->fetch();
  }
}