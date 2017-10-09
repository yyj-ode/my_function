<?php
/**
 * 功能 : 把数组转化成3级树的形式，主要用于生成管理页面左侧的导航栏，或网站的菜单栏
 * @param $array
 * 需要传入的数组
 * @param $parent_id_name
 * 父级id的字段名
 * @param $child_id_name
 * 子级id的字段名
 * @param $level_name
 * 层级名：层级最小为1，不是0
 * @return $result
 * 返回一个树形的数组
 */
function array_to_tree3($array,$parent_id_name,$child_id_name,$level_name){
    $result = [];
    $level_max = array_column($array,$level_name);
    $max = max($level_max);
//    echo '<pre>';print_r($max);die;
    foreach($array as $k => $v){
        if($v[$level_name] == 1){
            array_push($result,$v);
            unset($array[$k]);
        }
    }

    foreach($array as $k1 => $v1){
        foreach($result as $k2 => $v2){
            if($v1[$parent_id_name] == $v2[$child_id_name]){
                $result[$k2]['children'][] = $v1;
                unset($array[$k1]);
            }
        }
    }

    foreach($array as $k1 => $v1){
        foreach($result as $k2 => $v2){
            if(isset($result[$k2]['children'])){
                foreach($result[$k2]['children'] as $k3 => $v3) {
                    if ($v1[$parent_id_name] == $v3[$child_id_name]) {
                        $result[$k2]['children'][$k3]['children'][] = $v1;
                        unset($array[$k1]);
                    }
                }
            }
        }
    }
    return $result;
}

//====================================以下为 array_to_tree3 的例子=========================================
//$arr1 = [
//    ['catalog_id' => 11, 'catalog_name' => '本站用户', 'catalog_parent_id' => 2, 'catalog_level' => 2, 'catalog_view' => 'user',],
//    ['catalog_id' => 12, 'catalog_name' => '身份认证', 'catalog_parent_id' => 2, 'catalog_level' => 2, 'catalog_view' => 'identity',],
//    ['catalog_id' => 13, 'catalog_name' => '演绎认证', 'catalog_parent_id' => 2, 'catalog_level' => 2, 'catalog_view' => 'deductive',],
//    ['catalog_id' => 25, 'catalog_name' => '通告统计', 'catalog_parent_id' => 7, 'catalog_level' => 2, 'catalog_view' => 'statistics',],
//    ['catalog_id' => 26, 'catalog_name' => '通告统计的儿子', 'catalog_parent_id' => 25, 'catalog_level' => 3, 'catalog_view' => 'xxxxxx',],
//    ['catalog_id' => 2, 'catalog_name' => '用户管理', 'catalog_parent_id' => 0, 'catalog_level' => 1, 'catalog_view' => '',],
//    ['catalog_id' => 1, 'catalog_name' => '后台首页', 'catalog_parent_id' => 1, 'catalog_level' => 1, 'catalog_view' => 'home',],
//    ['catalog_id' => 7, 'catalog_name' => '通告管理', 'catalog_parent_id' => 0, 'catalog_level' => 1, 'catalog_view' => '',]
//];
//echo '<pre>';print_r($arr1);
//$parent_id_name = 'catalog_parent_id';
//$child_id_name = 'catalog_id';
//$level_name = 'catalog_level';
//$arr2 = array_to_tree3($arr1,$parent_id_name,$child_id_name,$level_name);
//echo '<br>';echo '<pre>';print_r($arr2);echo '<br>';
//==================================以上为 array_to_tree3 的例子=========================================


/**
 * 功能:打印数组
 * @param $array
 * @return bool
 */
function dumpp($array){
    if(is_array($array)){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }else{
        return false;
    }
}


///*
//  *@通过curl方式获取制定的图片到本地
//  *@ 完整的图片地址
//  *@ 要存储的文件名
// */
/**
 * @param string $url 图片的地址
 * @param string $filename 要保存的图片名
 * @return bool
 */
function getImg($url = "", $filename = "") {
    if(is_dir(basename($filename))) {
        echo "The Dir was not exits";
        return false;
    }
    //去除URL连接上面可能的引号
    $hander = curl_init();
    $fp = fopen($filename,'wb');
    curl_setopt($hander,CURLOPT_URL,$url);
    curl_setopt($hander,CURLOPT_FILE,$fp);
    $data = [
        "Referer:http://www.mzitu.com/101322",  //这个是为了防盗链，给一个请求头里的Referer过去
    ];
    curl_setopt($hander,CURLOPT_HTTPHEADER,$data);
    curl_exec($hander);
    curl_close($hander);
    fclose($fp);
    return  true;
}
//==================================以下为getImg例子==================================
//例如：
//$url = "http://i.meizitu.net/2017/09/28a03.jpg";
//$filename = './11/asdflak.jpg';
//getImg($url, $filename);
//==================================以上为getImg例子==================================

/**
 * @param $page -> 当前页数
 * @param $count -> 数据总条数
 * @return mixed
 */
function getPageList($page,$count){
    $data['count'] = ceil($count/6);    //总页数
    $data['total'] = $count;    //总数
    $data['page'] = $page;  //当前页
    $data['pre'] = $page-1;   //上一页
    if($data['pre'] < 1){
        $data['pre'] = 1;
    }
    $data['next'] = $page+1;  //下一页
    if($data['next'] > $data['count']){
        $data['next'] = $data['count'];
    }
    return $data;
}

