<?php
namespace Library;

/**
 * Arr
 * 数组类
 * @package Library
 */
class Arr {

    /**
     * @static
     * 数组去除空值
     * @param array $arr 数组
     * @param bool $trim 是否删除空字符值
     */
    public static function removeEmpty(array &$arr, $trim = true) {
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                self::removeEmpty($arr[$key]);
            }
            else {
                $value = ($trim == true) ? trim($value) : $value;
                if ($value == "") {
                    unset($arr[$key]);
                }
                else {
                    $arr[$key] = $value;
                }
            }
        }
    }

    /**
     * @static
     * 扁平化数组
     * @param array &$array 数组
     */
    public static function flatten(array &$array) {
        $i = 0;
        $n = count($array);
        while ($i < $n) {
            if (!is_array($array[$i])) {
                ++$i;
                continue;
            }
            array_splice($array, $i, 1, $array[$i]);
            $n = count($array);
        }
    }

    /**
     * @static
     * 转置二维数组
     * @param array $sourceArray
     * @return array 返回转置后的数组
     */
    public static function transpose(array $sourceArray) {
        $resultArray = null;
        $totalColumnKey = null;
        $linearCells = null;
        foreach ($sourceArray as $rowsKey => $columnArray) {
            if (is_array($columnArray)) {
                foreach ($columnArray as $columnKey => $value) {
                    $totalColumnKey[$columnKey] = '';
                    $resultArray[$columnKey][$rowsKey] = $value;
                }
            }
            else {
                $linearCells[$rowsKey] = $columnArray;
            }
        }
        if (is_null($linearCells)) {
            return $resultArray;
        }
        foreach ($linearCells as $rowsKey => $value) {
            foreach ($totalColumnKey as $columnKey => $empty) {
                $resultArray[$columnKey][$rowsKey] = $value;
            }
        }
        return $resultArray;
    }

    /**
     * 递归合并两个数组
     * @param array $array1 数组1
     * @param array $array2 数组2
     * @return array 合并后的数组
     */
    public static function merge($array1, $array2) {
        foreach ($array2 as $key => $value) {
            if (!isset($array1[$key])) {
                $array1[$key] = $value;
            }
            elseif (is_array($array1[$key]) && is_array($value)) {
                $array1[$key] = self::merge($array1[$key], $array2[$key]);
            }
            elseif (is_numeric($key) && $array1[$key] !== $array2[$key]) {
                $array1[] = $value;
            }
            else {
                $array1[$key] = $value;
            }
        }
        return $array1;
    }

    /**
     * @static
     * 引用数组
     * @param array $arr 任意数组
     * @return array 返回数组的引用
     */
    public static function pointer(array &$arr) {
        $toRefs = array();
        foreach ($arr as $key => $value)
            $toRefs[$key] = & $arr[$key];
        return $toRefs;
    }
}
