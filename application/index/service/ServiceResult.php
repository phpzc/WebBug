<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/9/4
 * Time: 10:35
 */

namespace app\index\service;


class ServiceResult implements \JsonSerializable,\ArrayAccess
{
    public $status = 0;
    public $message = '';
    public $data = [];


    /**
     * @param array $data    成功数据
     * @param string $message 成功信息
     * @return ServiceResult
     */
    public static function Success($data = [],$message = '')
    {
        return self::create(1,$data,$message);
    }

    /**
     * @param string $message 失败信息
     * @param array $data     失败数据
     * @return ServiceResult
     */
    public static function Error($message = '',$data = [])
    {
        return self::create(0,$data,$message);
    }

    /**
     * 创建返回结果对象
     *
     * @param int $status
     * @param string $message
     * @param array $data
     * @return ServiceResult
     */
    public static function create($status = 0,$data = [],$message = '')
    {
        $obj = new ServiceResult();
        $obj->status = $status;
        $obj->message = $message;
        $obj->data = $data;
        return $obj;
    }



    public function isSuccess()
    {
        return $this->status == 1;
    }


    public function toArray()
    {
        return ['status'=>$this->status,'data'=>$this->data,'message'=>$this->message];
    }


    public function __toString()
    {
        return json_encode($this->jsonSerialize(),JSON_UNESCAPED_UNICODE);
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return ['status'=>$this->status,'data'=>$this->data,'message'=>$this->message];
    }


    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
        if($offset != 'status' && $offset != 'data' && $offset != 'message'){
            return false;
        }

        return true;
    }

    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
        if($offset != 'status' && $offset != 'data' && $offset != 'message'){
            return null;
        }

        return $this->$offset;
    }

    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
        if($offset != 'status' && $offset != 'data' && $offset != 'message'){
            return;
        }

        $this->$offset = $value;
    }

    /**
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset) {
        // TODO: Implement offsetUnset() method.
        if($offset != 'status' && $offset != 'data' && $offset != 'message'){
            return;
        }

        if($offset == 'status'){
            $this->status = 0;
        }

        if($offset == 'data'){
            $this->data = [];
        }

        if($offset == 'message')
        {
            $this->message = '';
        }
    }

}