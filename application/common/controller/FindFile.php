<?php
/**遍历文件夹及文件类
 *Date:   2013-03-21
 *Author: fdipzone
 *Ver:    1.0
 */
class FindFile{

    public $files = array();    // 存储遍历的文件
    protected $maxdepth;        // 搜寻深度,0表示没有限制

    /*  遍历文件及文件夹
    *   @param String $spath     文件夹路径
    *   @param int    $maxdepth  搜寻深度,默认搜寻全部
    */
    public function process($spath, $maxdepth=0){
        if(isset($maxdepth) && is_numeric($maxdepth) && $maxdepth>0){
            $this->maxdepth = $maxdepth;
        }else{
            $this->maxdepth = 0;
        }
        $this->files = array();
        $this->traversing($spath); // 遍历
    }

    /*  遍历文件及文件夹
    *   @param String $spath 文件夹路径
    *   @param int    $depth 当前文件夹深度
    */
    private function traversing($spath, $depth=1){
        if($handle = opendir($spath)){
            while(($file=readdir($handle))!==false){
                if($file!='.' && $file!='..'){
                    $curfile = $spath.'/'.$file;

                    if(is_dir($curfile)){ // dir
                        if($this->maxdepth==0 || $depth<$this->maxdepth){ // 判断深度
                            $this->traversing($curfile, $depth+1);
                        }
                    }else{  // file
                        $this->handle($curfile);
                    }

                }
            }
            closedir($handle);
        }
    }

    /**处理文件方法
     *  @param String $file 文件路径
     */
    protected function handle($file){
        array_push($this->files, $file);
    }

}
?>