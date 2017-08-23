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