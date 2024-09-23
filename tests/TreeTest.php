<?php

namespace tests;

use tree\Tree;

class TreeTest extends \PHPUnit\Framework\TestCase
{
    public function testTreeGetChild()
    {
        $tree = new Tree();
        $tree_arr = [
            ['id' => 1, 'parent_id' => 0, 'name' => '一级栏目'],
            ['id' => 2, 'parent_id' => 0, 'name' => '二级栏目'],
            ['id' => 3, 'parent_id' => 2, 'name' => '三级栏目'],
            ['id' => 4, 'parent_id' => 2, 'name' => '三级栏目'],
        ];
        $tree->init($tree_arr);
        $sonLeaf = $tree->getChild(2);
        //print_r($sonLeaf);
        $this->assertEquals(2, count($sonLeaf));
    }

    //表示获得这个ID下的所有子级
    public function testTreeGetChildArr()
    {
        $tree = new Tree();
        $tree_arr = [
            ['id' => 1, 'parent_id' => 0, 'name' => '一级栏目'],
            ['id' => 2, 'parent_id' => 0, 'name' => '二级栏目'],
            ['id' => 3, 'parent_id' => 2, 'name' => '三级栏目'],
            ['id' => 4, 'parent_id' => 2, 'name' => '三级栏目'],
            ['id' => 5, 'parent_id' => 4, 'name' => '四级栏目'],
        ];
        $tree->init($tree_arr);
        $sonLeaf = $tree->getTreeArray(2);
        $this->assertEquals(2, count($sonLeaf));
    }

    public function testTreeGetParent()
    {
        $tree = new Tree();
        $tree_arr = [
            ['id' => 1, 'parent_id' => 0, 'name' => '一级栏目'],
            ['id' => 2, 'parent_id' => 0, 'name' => '二级栏目'],
            ['id' => 3, 'parent_id' => 2, 'name' => '三级栏目'],
        ];
        $tree->init($tree_arr);
        $Leaf = $tree->getParent(3);
        $this->assertEquals(2, $Leaf["id"]);
    }



}