# 使用

## form
addSelect2ajax
注意定义ajax请求地址，参数固定q page=1

## ajax_url 
返回
data: 列表 键值分别为text 和id 即可

## 测试代码
~~~
public function test_table($q='', $page = 1){
    if(Request::instance()->isAjax()){
        // 静态模拟
        return json([
            'data'=>[
                ['text'=>'吉佳便利超市','id'=>2],
                ['text'=>'吉祥馄饨','id'=>880],
            ]
        ]);
        // 动态查询
        $where['company_name'] = ['like', "%{$q}%"];
        $shop_list = Db::name('Shop')->where($where)->field('company_name AS text,id')->paginate(10);
        return json($shop_list);
    }else{
        return ZBuilder::make('form')
        ->addSelect2ajax('select', '测试','', [], '', url('test_table'))
        ->fetch();
    }
}
~~~