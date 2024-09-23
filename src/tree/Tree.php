<?php

namespace tree;
/**
 * 通用的树型类，可以生成任何树型结构
 */
class Tree
{

    /**
     * 生成树型结构所需要的2维数组
     * @var array
     */
    public $arr = [];

    /**
     * 生成树型结构所需修饰符号，可以换成图片
     * @var array
     */
    public $icon = ['│', '├', '└'];
    public $nbsp = "&nbsp;&nbsp;&nbsp;&nbsp;";
    private $str = '';
    /**
     * @access private
     */
    public $ret = '';

    /**
     * 构造函数，初始化类
     * @param array 2维数组，例如：
     *      array(
     *      1 => array('id'=>'1','parent_id'=>0,'name'=>'一级栏目一'),
     *      2 => array('id'=>'2','parent_id'=>0,'name'=>'一级栏目二'),
     *      3 => array('id'=>'3','parent_id'=>1,'name'=>'二级栏目一'),
     *      4 => array('id'=>'4','parent_id'=>1,'name'=>'二级栏目二'),
     *      5 => array('id'=>'5','parent_id'=>2,'name'=>'二级栏目三'),
     *      6 => array('id'=>'6','parent_id'=>3,'name'=>'三级栏目一'),
     *      7 => array('id'=>'7','parent_id'=>3,'name'=>'三级栏目二')
     *      )
     * @return array
     */
    public function init($arr = [])
    {
        $this->arr = $arr;
        $this->ret = '';
        return is_array($arr);
    }

    /**
     * 得到父级数组
     * @param int
     * @return array
     */
    public function getParent($myId)
    {
        $indexed_arr = array_column($this->arr,null,'id');
        // 找到子元素
        if (isset($indexed_arr[$myId])) {
            $child = $indexed_arr[$myId];
            // 如果 parent_id 为 0，则没有父数组
            if ($child['parent_id'] === 0) {
                return null;
            }
            // 返回父数组
            return $indexed_arr[$child['parent_id']] ?? null;
        }
        return null;
    }

    /**
     * 得到子级数组
     * @param int
     * @return array
     */
    public function getChild($myId)
    {
        $newArr = [];
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {

                if ($a['parent_id'] == $myId) {
                    $newArr[$id] = $a;
                }
            }
        }

        return $newArr ? $newArr : false;
    }


    /*
     * 生成树型结构数组
     * @param int myID，表示获得这个ID下的所有子级
     * @param int $maxLevel 最大获取层级,默认不限制
     * @param int $level    当前层级,只在递归调用时使用,真实使用时不传入此参数
     * @return array
     */
    public function getTreeArray($myId, $maxLevel = 0, $level = 1)
    {
        $returnArray = [];
        //一级数组
        $children = $this->getChild($myId);
        if (is_array($children)) {
            foreach ($children as $child) {
                $child['_level']           = $level;
                $returnArray[$child['id']] = $child;
                if ($maxLevel === 0 || ($maxLevel !== 0 && $maxLevel > $level)) {
                    $mLevel                                = $level + 1;
                    $returnArray[$child['id']]["children"] = $this->getTreeArray($child['id'], $maxLevel, $mLevel);
                }

            }
        }
        return $returnArray;
    }

    public function createTree($idField = 'id', $parentIdField = 'parent_id', $childrenField = "children")
    {
        $tree = [];
        $list = array_column($this->arr, null, $idField);
        foreach ($list as $v) {
            if (isset($list[$v[$parentIdField]])) {
                $list[$v[$parentIdField]][$childrenField][] = &$list[$v[$idField]];
            } else {
                $tree[] =& $list[$v[$idField]];
            }
        }
        return $tree;
    }

}