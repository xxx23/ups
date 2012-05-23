<?php
require_once 'UPS/Model/Db.php';

/**
 * Service的資料操作
 *  @author wewe0901
 */
class UPS_Model_Services extends UPS_Model_Db
{
    /**
     * web service的table name
     * @var string
     */
    protected $_tableName = 'ups_ws_services';

    /**
     * 查詢服務是否存在 可以用 service_id 也可以用 calss name
     * @param mixed $service
     * @return boolean
     */
    public function serviceExists($service)
    {
        if(empty($service))
            return false;
        if(is_int($service)){ 
            $result =  db_getRow("SELECT * 
                              FROM ups_ws_services
                              WHERE id = '{$service}'");
        }
        elseif(is_string($service))
        {
             $result =  db_getRow("SELECT * 
                              FROM ups_ws_services
                              WHERE class = '{$service}'");
        }
        return !empty($result);
    }

    /**
     * 儲存資料 如果有id就更新資料 如果吳就新增資料
     * @param array  $data
     * @return UPS_Model_Services
     */
    public function saveService($data)
    {
        if(empty($data)
            or !is_array($data))
            return false;

        if(!empty($data['id']))
            $this->update($data,"id={$data['id']}");
        else
            $this->insert($data);
        return $this;
    }

    /**
     * 取得 所有servcie的選擇列表 用於 html option
     * @return array
     */
    public function getServicesSelect()
    {
        $datas = db_getAll("SELECT id,name
                           FROM {$this->_tableName}
                           WHERE 1");
        $dataOut = array();
        foreach($datas as $data)
        {
            $dataOut[$data['id']] = $data['name'];
        }
        return array('keys'=>array_keys($dataOut),
                     'values'=>array_values($dataOut));
    }
    public function getServiceIdByClassName($name)
    {  
        return db_getOne("SELECT id FROM {$this->_tableName} WHERE class='{$name}' ;" );
    }
    /**
     * 根據條件取得服務
     * @param array $where
     * @return array
     */
    public function getServices($where = null)
    {
        if(!empty($where) && is_array($where))
        {
            $conditions = array();
            if(!empty($where['id']))
                $conditions[] = 'id='.$where['id']; 
            $where = implode(' AND ',$conditions);
        }
        else $where =1;
        return db_getAll("SELECT *
            FROM ups_ws_services
            WHERE $where ;");
    }
    
    public function getServiceName($serviceId)
    {
        if(!isset($this->_serviceCache[$serviceId]))
        {
            $this->_serviceCache[$serviceId] = db_getRow("
                SELECT * FROM {$this->_tableName}
                WHERE id = '$serviceId';
                ");
        }
        return $this->_serviceCache[$serviceId]['name'];
    }
    /**
     * 取得輸入的使用者身分可存取的service
     * role_cd = register_applycourse.category
     *
     * @param int $role_cd
     * @return array
     */
    public function getActiveServices($role_cd)
    {
        if(empty($role_cd))
            return array();
        
        return db_getAll("SELECT *
                    FROM ups_ws_services
                    WHERE status = 1 
                    AND id in (SELECT service_id
                                FROM ups_ws_permission
                                WHERE role_cd = '{$role_cd}');");
    }

    /**
     * 刪除指定的 service
     * @param int $service_id
     * @return UPS_Model_Services
     */
    public function deleteService($service_id)
    {
        if(!empty($service_id)){
            db_query("DELETE FROM ups_ws_services
                WHERE id = {$service_id};");
            db_query("DELETE FROM ups_ws_permission
            WHERE id = {$service_id};");
         
        }
        return $this;    
    }
    /**
     * 取得服務的權限資料
     * @param string $where
     * @return array
     */
    public function getPermissions($where = null)
    {
        $where = empty($where)? 1 : $where;
        $data = db_getAll("SELECT S.name, P.*
                           FROM ups_ws_services S, ups_ws_permission P
                           WHERE S.id = P.service_id
                           AND {$where};");
        $permissions = array();

        foreach($data as $row)
        {
            $permissions[$row["service_id"]][] = $row["role_cd"];
        }
        return $permissions;

    }

    /**
     * 新增service的權限
     * @param int $service_id
     * @param int $role_cd
     * @return UPS_Model_Services
     */
    public function addPermission($service_id,$role_cd)
    {
        if(empty($service_id)
            or empty($role_cd))
            return false;       
        db_query("INSERT INTO ups_ws_permission(service_id,role_cd)
                   VALUES ({$service_id},'{$role_cd}')");
        return $this;
    }
    /**
     * 刪除service的權限
     * @param int $service_id
     * @param int $role_cd
     * @return UPS_Model_Services
     */
    public function removePermission($service_id,$role_cd)
    {
        if(empty($service_id)
            or empty($role_cd))
            return false;
        db_query("DELETE FROM ups_ws_permission
                      WHERE service_id = {$service_id}
                      AND role_cd = '{$role_cd}'");

        return $this;
    }

    /**
     * 查詢此角色(role_cd)是否有存取 service(service_id)的權限
     * @param int $service_id
     * @param int $role_cd
     * @return boolean
     */
    public function permissionExists($service_id,$role_cd)
    {
        if(empty($service_id)
            or empty($role_cd))
            return false;

        $row = db_getRow("SELECT *
                          FROM ups_ws_services,ups_ws_permission P
                          WHERE service_id = {$service_id}
                          AND role_cd = {$role_cd}");
        
        return !empty($row);
    }

}
//END OF Services.php
