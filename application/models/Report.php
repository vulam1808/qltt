<?php
include APPLICATION_PATH."/models/base/ReportBase.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Report extends Model_ReportBase{
    
}
class Model_ReportMapper extends Model_ReportMapperBase{
    public function deleteMaster_Unit($id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select ="UPDATE master_unit SET is_delete='1'  WHERE id='".$id."'" ;
        $stmt=$db->query($select);             
        $stmt->closeCursor(); 
    }
     //tra ve id theo cot va gia tri can tim
    public function findidbyname($colums,$valueColums){        
       $db = Zend_Db_Table::getDefaultAdapter();
        $select= "select id from master_unit where ".$colums."='".$valueColums."' and is_delete ='0'";
        $stmt=$db->query($select);
        $row = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        if($row==NULL){
            return null;
        }
        return $row[0]->id;  
    }
    public function fetchAll(){
         $db = Zend_Db_Table::getDefaultAdapter();
        $select="select * from master_unit where is_delete ='0'";        
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $entry = new Model_Master_Unit();
            $entry->setId($row->id)
                  ->setId($row->id)
                ->setName($row->name)
                ->setCode($row->code)     
                ->setCreated_Date($row->created_date)
                ->setCreated_By($row->created_by)
                ->setModified_Date($row->modified_date)
                ->setModified_By($row->modified_by)              
                ->setOrder($row->order)
                ->setStatus($row->status)
                ->setComment($row->comment)
                ->setIs_Delete($row->is_delete);
                
            $entries[]=$entry;
        }
        return $entries;
    }

    public function fetchResult($quy,$year){
        if($quy==1){
            $begin = 1;
            $end = 3;
        }
        if($quy==2){
            $begin = 4;
            $end = 6;
        }
        if($quy==3){
            $begin = 7;
            $end = 9;
        }
        if($quy==4){
            $begin = 10;
            $end = 12;
        }

        $db = Zend_Db_Table::getDefaultAdapter();
        $entriess1   = array("department"=>"","result"=>"");
        $entriess = array("result"=>"");
        $select="select code from master_violation";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
            $entriess[$row->code]="";
            $entriess1[$row->code]="";
        }
        $entries=$entriess;
        $entries1=$entriess1;
        $entries2 = array();
        $select="select count(*) count,sys_department_id from info_schedule_check where (month(date_check) between '".$begin."' and '".$end."') and year(date_check)='".$year."' group by sys_department_id";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
            $entries=$entriess;
            $entries1=$entriess1;
            $selects="select count(*) count,sys_department_id from doc_violations_handling where (month(date_violation) between '".$begin."' and '".$end."') and year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'";
            $stmts=$db->query($selects);
            $rowss = $stmts->fetchAll(PDO::FETCH_CLASS);
            $stmts->closeCursor();
            foreach($rowss as $row1)
                $entries1["department"]=  GlobalLib::getName("sys_department",$row->sys_department_id,"name");
            $entries1["result"]=$row->count."/".$row1->count;


            $select1= "select name,code,count(name) count,Sum(amount) sums FROM doc_violations_handling mv
                        inner join master_violation dvh on mv.master_violation_id=dvh.id
                       WHERE (mv.is_delete = 0) and (month(date_violation) between '".$begin."' and '".$end."') and year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'  group by name";
            $stmt1=$db->query($select1);
            $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
            $stmt1->closeCursor();
            foreach($rows1 as $row2){
                $sum = $row2->sums;
                if(empty($sum))
                {
                    $sum = 0;
                }
                $entries[$row2->code]= $sum;
                $entries["result"]= $sum+$entries["result"];
                $entries1[$row2->code]= $row2->count;
            }
            $entries2[] = array($entries1,$entries);
        }
        return $entries2;
    }

    // Lan Duong
    public function fetchDSKinhDoanh($type_business, $doanhnghiep_id, $nganhnghe_id, $tinhthanh_id, $loaihinh_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = "select info_business.code, info_business.name , info_business.address_office, master_province.name as master_province_id, master_district.name as master_district_id, master_ward.name as master_ward_id, info_business.work_business";
        $select .= " from info_business left join master_province on info_business.master_province_id = master_province.id";
        $select .= " left join master_district on info_business.master_district_id = master_district.id";
        $select .= " left join master_ward on info_business.master_ward_id = master_ward.id";
        $select .= " where info_business.type_business='".$type_business."' and info_business.is_delete ='0'";
        if($type_business == 'DoanhNghiep') {
            if ($doanhnghiep_id != null) {
                $select .= "  and info_business.code in (" . $doanhnghiep_id . ")";
            }
            if ($nganhnghe_id != null) {
                $select .= " and info_business.work_business in (" . $nganhnghe_id . ")";
            }
            if ($tinhthanh_id != null) {
                $select .= " and info_business.master_province_id in (" . $tinhthanh_id . ")";
            }

            if ($loaihinh_id != null) {
                $select .= " and info_business.master_business_type_id in (" . $loaihinh_id . ")";
            }
        }

        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $array=array(
                'code'=>$row->code,
                'name'=>$row->name,
                'address_office'=>$row->address_office,
                'master_province_id'=>$row->master_province_id,
                'master_district_id'=>$row->master_district_id,
                'master_ward_id'=>$row->master_ward_id,
                'work_business'=>$row->work_business
            );
            array_push($entries,$array);
        }
        return $entries;
    }

    public function fetchrRowCountDSKinhDoanh($type_business, $doanhnghiep_id, $nganhnghe_id, $tinhthanh_id, $loaihinh_id){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = "select info_business.code, info_business.name , info_business.address_office, master_province.name as master_province_id, master_district.name as master_district_id, master_ward.name as master_ward_id, info_business.work_business";
        $select .= " from info_business left join master_province on info_business.master_province_id = master_province.id";
        $select .= " left join master_district on info_business.master_district_id = master_district.id";
        $select .= " left join master_ward on info_business.master_ward_id = master_ward.id";
        $select .= " where info_business.type_business='".$type_business."' and info_business.is_delete ='0'";
        if($type_business == 'DoanhNghiep') {
            if ($doanhnghiep_id != null) {
                $select .= "  and info_business.code in (" . $doanhnghiep_id . ")";
            }
            if ($nganhnghe_id != null) {
                $select .= " and info_business.work_business in (" . $nganhnghe_id . ")";
            }
            if ($tinhthanh_id != null) {
                $select .= " and info_business.master_province_id in (" . $tinhthanh_id . ")";
            }

            if ($loaihinh_id != null) {
                $select .= " and info_business.master_business_type_id in (" . $loaihinh_id . ")";
            }
        }

        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        $i = 0;
        foreach ($rows as $row){
            $i++;
        }
        return $i;
    }

    public function fetchDSXuLiViPham($type_business,$id,$month,$year){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = "";
        if($id==NULL) {
            $select = "SELECT doc_violations_handling.id, info_business.name AS TenDoanhNghiep, info_business.address_office AS DiaChi, master_violation.Name AS HanhViViPham, master_sanction.name AS HinhThucXuLy, sys_user.username AS DoiXuLy, doc_violations_handling.amount AS SoTien";
            $select .= " FROM doc_violations_handling inner join info_business on info_business.type_business='".$type_business."'";
            $select .= " inner join master_violation on doc_violations_handling.master_violation_id=master_violation.id";
            $select .= " inner join master_sanction on doc_violations_handling.master_sanctions_id=master_sanction.id";
            $select .= " inner join sys_user on doc_violations_handling.sys_user_id=sys_user.id";
            $select .= " WHERE doc_violations_handling.info_business_id= info_business.id and month(doc_violations_handling.date_violation)='".$month."'and year(doc_violations_handling.date_violation)='".$year."'";
        }
        else
        {
            $select = "SELECT doc_violations_handling.id, info_business.name AS TenDoanhNghiep, info_business.address_office AS DiaChi, master_violation.Name AS HanhViViPham, master_sanction.name AS HinhThucXuLy, sys_user.username AS DoiXuLy, doc_violations_handling.amount AS SoTien";
            $select .= " FROM doc_violations_handling inner join info_business on info_business.type_business='".$type_business."'";
            $select .= " inner join master_violation on doc_violations_handling.master_violation_id=master_violation.id";
            $select .= " inner join master_sanction on doc_violations_handling.master_sanctions_id=master_sanction.id";
            $select .= " inner join sys_user on doc_violations_handling.sys_user_id=sys_user.id";
            $select .= " WHERE doc_violations_handling.info_business_id= info_business.id and month(doc_violations_handling.date_violation)='".$month."'and year(doc_violations_handling.date_violation)='".$year."' and doc_violations_handling.sys_department_id='".$id."'";
        }
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $array=array(
                'id'=>$row->id,
                'TenDoanhNghiep'=>$row->TenDoanhNghiep,
                'DiaChi'=>$row->DiaChi,
                'HanhViViPham'=>$row->HanhViViPham,
                'HinhThucXuLy'=>$row->HinhThucXuLy,
                'DoiXuLy'=>$row->DoiXuLy,
                'SoTien'=>$row->SoTien
            );
            array_push($entries,$array);
        }
        return $entries;
    }

    public function fetchRowCountDSXuLiViPham($type_business,$id,$month,$year){
        $db = Zend_Db_Table::getDefaultAdapter();
        if($id==NULL) {
            $select = "SELECT doc_violations_handling.id, info_business.name AS TenDoanhNghiep, info_business.address_office AS DiaChi, master_violation.Name AS HanhViViPham, master_sanction.name AS HinhThucXuLy, sys_user.username AS DoiXuLy, doc_violations_handling.amount AS SoTien";
            $select .= " FROM doc_violations_handling inner join info_business on info_business.type_business='".$type_business."'";
            $select .= " inner join master_violation on doc_violations_handling.master_violation_id=master_violation.id";
            $select .= " inner join master_sanction on doc_violations_handling.master_sanctions_id=master_sanction.id";
            $select .= " inner join sys_user on doc_violations_handling.sys_user_id=sys_user.id";
            $select .= " WHERE doc_violations_handling.info_business_id= info_business.id and month(doc_violations_handling.date_violation)='".$month."'and year(doc_violations_handling.date_violation)='".$year."'";
        }
        else
        {
            $select = "SELECT doc_violations_handling.id, info_business.name AS TenDoanhNghiep, info_business.address_office AS DiaChi, master_violation.Name AS HanhViViPham, master_sanction.name AS HinhThucXuLy, sys_user.username AS DoiXuLy, doc_violations_handling.amount AS SoTien";
            $select .= " FROM doc_violations_handling inner join info_business on info_business.type_business='".$type_business."'";
            $select .= " inner join master_violation on doc_violations_handling.master_violation_id=master_violation.id";
            $select .= " inner join master_sanction on doc_violations_handling.master_sanctions_id=master_sanction.id";
            $select .= " inner join sys_user on doc_violations_handling.sys_user_id=sys_user.id";
            $select .= " WHERE doc_violations_handling.info_business_id= info_business.id and month(doc_violations_handling.date_violation)='".$month."'and year(doc_violations_handling.date_violation)='".$year."' and doc_violations_handling.sys_department_id='".$id."'";
        }
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        $i = 0;
        foreach ($rows as $row){
            $i++;
        }
        return $i;
    }

    public function fetchDSTangVatTamGiu($status,$month,$year)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="";
        $select1 = "select doc_items_handling.id, master_items.name AS TenHangHoa, info_business.name AS TenDoanhNghiep, doc_items_handling.serial_handling AS BienLaiTichThu, doc_items_handling.quantity_commodity AS SoLuong, master_unit.name AS DonViTinh, doc_items_handling.date_handling AS NgayTichThu, doc_items_handling.amount AS SoTien, master_sanction.name AS TrangThai";
        $select1 .= " from doc_items_handling inner join master_items on doc_items_handling.master_items_id=master_items.id";
        $select1 .= " left join info_business on doc_items_handling.doc_violations_handling_id=info_business.id";
        $select1 .= " left join master_unit on doc_items_handling.master_unit_id=master_unit.id";
        $select1 .= " left join master_sanction on doc_items_handling.master_sanction_id=master_sanction.id";
        $select1 .= " where doc_items_handling.is_delete ='0' and month(doc_items_handling.date_handling)='".$month."' and year(doc_items_handling.date_handling)='".$year."' and (doc_items_handling.status='TG-CXL_TG' or doc_items_handling.status='TL_TG' or doc_items_handling.status='CGCQK_TG' or doc_items_handling.status='XLN_TG')";

        $select2 = "select doc_items_handling.id, master_items.name AS TenHangHoa, info_business.name AS TenDoanhNghiep, doc_items_handling.serial_handling AS BienLaiTichThu, doc_items_handling.quantity_commodity AS SoLuong, master_unit.name AS DonViTinh, doc_items_handling.date_handling AS NgayTichThu, doc_items_handling.amount AS SoTien, master_sanction.name AS TrangThai";
        $select2 .= " from doc_items_handling inner join master_items on doc_items_handling.master_items_id=master_items.id";
        $select2 .= " left join info_business on doc_items_handling.doc_violations_handling_id=info_business.id";
        $select2 .= " left join master_unit on doc_items_handling.master_unit_id=master_unit.id";
        $select2 .= " left join master_sanction on doc_items_handling.master_sanction_id=master_sanction.id";
        $select2 .= " where doc_items_handling.is_delete ='0' and (month(doc_items_handling.date_handling)='".$month."' and year(doc_items_handling.date_handling)='".$year."' and doc_items_handling.status='".$status."')";

        if($status == "ALL"){
            $select =  $select1;
        }else{
            $select =  $select2;
        }

        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $array=array(
                'id'=>$row->id,
                'TenHangHoa'=>$row->TenHangHoa,
                'TenDoanhNghiep'=>$row->TenDoanhNghiep,
                'BienLaiTichThu'=>$row->BienLaiTichThu,
                'SoLuong'=>$row->SoLuong,
                'DonViTinh'=>$row->DonViTinh,
                'NgayTichThu'=>$row->NgayTichThu,
                'SoTien'=>$row->SoTien,
                'TrangThai'=>$row->TrangThai
            );
            array_push($entries,$array);
        }
        return $entries;
    }

    public function fetchRowCountDSTangVatTamGiu($status,$month,$year)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="";

        $select1 = "select doc_items_handling.id, master_items.name AS TenHangHoa, info_business.name AS TenDoanhNghiep, doc_items_handling.serial_handling AS BienLaiTichThu, doc_items_handling.quantity_commodity AS SoLuong, master_unit.name AS DonViTinh, doc_items_handling.date_handling AS NgayTichThu, doc_items_handling.amount AS SoTien, master_sanction.name AS TrangThai";
        $select1 .= " from doc_items_handling inner join master_items on doc_items_handling.master_items_id=master_items.id";
        $select1 .= " left join info_business on doc_items_handling.doc_violations_handling_id=info_business.id";
        $select1 .= " left join master_unit on doc_items_handling.master_unit_id=master_unit.id";
        $select1 .= " left join master_sanction on doc_items_handling.master_sanction_id=master_sanction.id";
        $select1 .= " where doc_items_handling.is_delete ='0' and month(doc_items_handling.date_handling)='".$month."' and year(doc_items_handling.date_handling)='".$year."' and (doc_items_handling.status='TG-CXL_TG' or doc_items_handling.status='TL_TG' or doc_items_handling.status='CGCQK_TG' or doc_items_handling.status='XLN_TG')";

        $select2 = "select doc_items_handling.id, master_items.name AS TenHangHoa, info_business.name AS TenDoanhNghiep, doc_items_handling.serial_handling AS BienLaiTichThu, doc_items_handling.quantity_commodity AS SoLuong, master_unit.name AS DonViTinh, doc_items_handling.date_handling AS NgayTichThu, doc_items_handling.amount AS SoTien, master_sanction.name AS TrangThai";
        $select2 .= " from doc_items_handling inner join master_items on doc_items_handling.master_items_id=master_items.id";
        $select2 .= " left join info_business on doc_items_handling.doc_violations_handling_id=info_business.id";
        $select2 .= " left join master_unit on doc_items_handling.master_unit_id=master_unit.id";
        $select2 .= " left join master_sanction on doc_items_handling.master_sanction_id=master_sanction.id";
        $select2 .= " where doc_items_handling.is_delete ='0' and (month(doc_items_handling.date_handling)='".$month."' and year(doc_items_handling.date_handling)='".$year."' and doc_items_handling.status='".$status."')";

        if($status == "ALL"){
            $select =  $select1;
        }else{
            $select =  $select2;
        }

        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        $i = 0;
        foreach ($rows as $row){
            $i++;
        }
        return $i;
    }

    public function fetchDSTangVatTichThu($status,$month,$year)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="";

        $select1 = "select doc_items_handling.id, master_items.name AS TenHangHoa, info_business.name AS TenDoanhNghiep, doc_items_handling.serial_handling AS BienLaiTichThu, doc_items_handling.quantity_commodity AS SoLuong, master_unit.name AS DonViTinh, doc_items_handling.date_handling AS NgayTichThu, doc_items_handling.amount AS SoTien, master_sanction.name AS TrangThai";
        $select1 .= " from doc_items_handling inner join master_items on doc_items_handling.master_items_id=master_items.id";
        $select1 .= " left join info_business on doc_items_handling.doc_violations_handling_id=info_business.id";
        $select1 .= " left join master_unit on doc_items_handling.master_unit_id=master_unit.id";
        $select1 .= " left join master_sanction on doc_items_handling.master_sanction_id=master_sanction.id";
        $select1 .= " where doc_items_handling.is_delete ='0' and month(doc_items_handling.date_handling)='".$month."' and year(doc_items_handling.date_handling)='".$year."' and (doc_items_handling.status='TT_TT' or doc_items_handling.status='TH_TT' or doc_items_handling.status='ĐG_TT' or doc_items_handling.status='CGCQKSD_TT' or doc_items_handling.status='XLN_TT')";

        $select2 = "select doc_items_handling.id, master_items.name AS TenHangHoa, info_business.name AS TenDoanhNghiep, doc_items_handling.serial_handling AS BienLaiTichThu, doc_items_handling.quantity_commodity AS SoLuong, master_unit.name AS DonViTinh, doc_items_handling.date_handling AS NgayTichThu, doc_items_handling.amount AS SoTien, master_sanction.name AS TrangThai";
        $select2 .= " from doc_items_handling inner join master_items on doc_items_handling.master_items_id=master_items.id";
        $select2 .= " left join info_business on doc_items_handling.doc_violations_handling_id=info_business.id";
        $select2 .= " left join master_unit on doc_items_handling.master_unit_id=master_unit.id";
        $select2 .= " left join master_sanction on doc_items_handling.master_sanction_id=master_sanction.id";
        $select2 .= " where doc_items_handling.is_delete ='0' and (month(doc_items_handling.date_handling)='".$month."' and year(doc_items_handling.date_handling)='".$year."' and doc_items_handling.status='".$status."')";

        if($status == "ALL"){
            $select =  $select1;
        }else{
            $select =  $select2;
        }

        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $array=array(
                'id'=>$row->id,
                'TenHangHoa'=>$row->TenHangHoa,
                'TenDoanhNghiep'=>$row->TenDoanhNghiep,
                'BienLaiTichThu'=>$row->BienLaiTichThu,
                'SoLuong'=>$row->SoLuong,
                'DonViTinh'=>$row->DonViTinh,
                'NgayTichThu'=>$row->NgayTichThu,
                'SoTien'=>$row->SoTien,
                'TrangThai'=>$row->TrangThai
            );
            array_push($entries,$array);
        }
        return $entries;
    }

    public function fetchRowCountDSTangVatTichThu($status,$month,$year)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select="";

        $select1 = "select doc_items_handling.id, master_items.name AS TenHangHoa, info_business.name AS TenDoanhNghiep, doc_items_handling.serial_handling AS BienLaiTichThu, doc_items_handling.quantity_commodity AS SoLuong, master_unit.name AS DonViTinh, doc_items_handling.date_handling AS NgayTichThu, doc_items_handling.amount AS SoTien, master_sanction.name AS TrangThai";
        $select1 .= " from doc_items_handling inner join master_items on doc_items_handling.master_items_id=master_items.id";
        $select1 .= " left join info_business on doc_items_handling.doc_violations_handling_id=info_business.id";
        $select1 .= " inner join master_unit on doc_items_handling.master_unit_id=master_unit.id";
        $select1 .= " inner join master_sanction on doc_items_handling.master_sanction_id=master_sanction.id";
        $select1 .= " where doc_items_handling.is_delete ='0' and month(doc_items_handling.date_handling)='".$month."' and year(doc_items_handling.date_handling)='".$year."' and (doc_items_handling.status='TT_TT' or doc_items_handling.status='TH_TT' or doc_items_handling.status='ĐG_TT' or doc_items_handling.status='CGCQKSD_TT' or doc_items_handling.status='XLN_TT')";

        $select2 = "select doc_items_handling.id, master_items.name AS TenHangHoa, info_business.name AS TenDoanhNghiep, doc_items_handling.serial_handling AS BienLaiTichThu, doc_items_handling.quantity_commodity AS SoLuong, master_unit.name AS DonViTinh, doc_items_handling.date_handling AS NgayTichThu, doc_items_handling.amount AS SoTien, master_sanction.name AS TrangThai";
        $select2 .= " from doc_items_handling inner join master_items on doc_items_handling.master_items_id=master_items.id";
        $select2 .= " left join info_business on doc_items_handling.doc_violations_handling_id=info_business.id";
        $select2 .= " inner join master_unit on doc_items_handling.master_unit_id=master_unit.id";
        $select2 .= " inner join master_sanction on doc_items_handling.master_sanction_id=master_sanction.id";
        $select2 .= " where doc_items_handling.is_delete ='0' and (month(doc_items_handling.date_handling)='".$month."' and year(doc_items_handling.date_handling)='".$year."' and doc_items_handling.status='".$status."')";

        if($status == "ALL"){
            $select =  $select1;
        }else{
            $select =  $select2;
        }

        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        $i = 0;
        foreach ($rows as $row){
            $i++;
        }
        return $i;
    }

    public function fetchNhatKiTheoDoi($ngaybatdau,$ngayketthuc,$userID = null)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $ngaybatdau = GlobalLib::toMysqlDateString($ngaybatdau);
        $ngayketthuc = GlobalLib::toMysqlDateString($ngayketthuc);
        if($ngaybatdau==NULL && $ngayketthuc==NULL){
            $select="select * from doc_diary where is_delete ='0' and created_by = '".$userID."'";
        }
        else {
            $select="select * from doc_diary where created_by = '".$userID."' and is_delete ='0' and date_diary BETWEEN CAST('$ngaybatdau' AS DATE) AND CAST('$ngayketthuc' AS DATE) ";
            if($userID===NULL)
                $select="select * from doc_diary where date_diary BETWEEN CAST('$ngaybatdau' AS DATE) AND CAST('$ngayketthuc' AS DATE) and is_delete ='0'";
        }

        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        foreach ($rows as $row){
            $array=array(
                'id'=>$row->id,
                'date_diary'=>$row->date_diary,
                'implementers'=>$row->implementers,
                'position'=>$row->position,
                'content_inspection'=>$row->content_inspection,
                'time_check'=>$row->time_check,
                'status_and_test_results'=>$row->status_and_test_results,
                'processing_results'=>$row->processing_results,
            );
            array_push($entries,$array);
        }
        return $entries;
    }

    public function fetchRowCountNhatKiTheoDoi($ngaybatdau,$ngayketthuc,$userID = null)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $ngaybatdau = GlobalLib::toMysqlDateString($ngaybatdau);
        $ngayketthuc = GlobalLib::toMysqlDateString($ngayketthuc);
        if($ngaybatdau==NULL && $ngayketthuc==NULL){
            $select="select * from doc_diary where is_delete ='0' and created_by = '".$userID."'";
        }
        else {
            $select="select * from doc_diary where created_by = '".$userID."' and is_delete ='0' and date_diary BETWEEN CAST('$ngaybatdau' AS DATE) AND CAST('$ngayketthuc' AS DATE) ";
            if($userID===NULL)
                $select="select * from doc_diary where date_diary BETWEEN CAST('$ngaybatdau' AS DATE) AND CAST('$ngayketthuc' AS DATE) and is_delete ='0'";
        }

        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $entries = array();
        $i = 0;
        foreach ($rows as $row){
            $i++;
        }
        return $i;
    }

    public function fetchDSBCKiemTraTheoQui($quy,$year, $sys_department_id = null){
        if($quy==1){
            $begin = 1;
            $end = 3;
        }
        if($quy==2){
            $begin = 4;
            $end = 6;
        }
        if($quy==3){
            $begin = 7;
            $end = 9;
        }
        if($quy==4){
            $begin = 10;
            $end = 12;
        }

        $db = Zend_Db_Table::getDefaultAdapter();
        $entriess1   = array("department"=>"","result"=>"");
        $entriess = array("result"=>"");
        $select="select code from master_violation";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
            $entriess[$row->code]="";
            $entriess1[$row->code]="";
        }
        $entries=$entriess;
        $entries1=$entriess1;
        $entries2 = array();
        if($sys_department_id === null)
            $select="select count(*) count,sys_department_id from info_schedule_check where (month(date_check) between '".$begin."' and '".$end."') and year(date_check)='".$year."' group by sys_department_id";
        else
            $select="select count(*) count,sys_department_id from info_schedule_check where (month(date_check) between '".$begin."' and '".$end."') and year(date_check)='".$year."' and sys_department_id='".$sys_department_id."' group by sys_department_id";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
            $entries=$entriess;
            $entries1=$entriess1;
            $selects="select count(*) count,sys_department_id from doc_violations_handling where (month(date_violation) between '".$begin."' and '".$end."') and year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'";
            $stmts=$db->query($selects);
            $rowss = $stmts->fetchAll(PDO::FETCH_CLASS);
            $stmts->closeCursor();
            foreach($rowss as $row1)
                $entries1["department"]=  GlobalLib::getName("sys_department",$row->sys_department_id,"name");
            $entries1["result"]=$row->count."/".$row1->count;


            $select1= "select name,code,count(name) count,Sum(amount) sums FROM doc_violations_handling mv
                        inner join master_violation dvh on mv.master_violation_id=dvh.id
                       WHERE (mv.is_delete = 0) and (month(date_violation) between '".$begin."' and '".$end."') and year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'  group by name";
            $stmt1=$db->query($select1);
            $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
            $stmt1->closeCursor();
            foreach($rows1 as $row2){
                $sum = $row2->sums;
                if(empty($sum))
                {
                    $sum = 0;
                }
                $entries[$row2->code]= $sum;
                $entries["result"]= $sum+$entries["result"];
                $entries1[$row2->code]= $row2->count;
            }
            $entries2[] = array($entries1,$entries);
        }
        return $entries2;
    }

    public function fetchRowCountDSBCKiemTraTheoQui($quy,$year, $sys_department_id = null){
        if($quy==1){
            $begin = 1;
            $end = 3;
        }
        if($quy==2){
            $begin = 4;
            $end = 6;
        }
        if($quy==3){
            $begin = 7;
            $end = 9;
        }
        if($quy==4){
            $begin = 10;
            $end = 12;
        }

        $db = Zend_Db_Table::getDefaultAdapter();
        $entriess1   = array("department"=>"","result"=>"");
        $entriess = array("result"=>"");
        $select="select code from master_violation";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
            $entriess[$row->code]="";
            $entriess1[$row->code]="";
        }
        $entries=$entriess;
        $entries1=$entriess1;
        $entries2 = array();
        if($sys_department_id === null)
            $select="select count(*) count,sys_department_id from info_schedule_check where (month(date_check) between '".$begin."' and '".$end."') and year(date_check)='".$year."' group by sys_department_id";
        else
            $select="select count(*) count,sys_department_id from info_schedule_check where (month(date_check) between '".$begin."' and '".$end."') and year(date_check)='".$year."' and sys_department_id='".$sys_department_id."' group by sys_department_id";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $i = 0;
        foreach($rows as $row){
            $entries=$entriess;
            $entries1=$entriess1;
            $selects="select count(*) count,sys_department_id from doc_violations_handling where (month(date_violation) between '".$begin."' and '".$end."') and year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'";
            $stmts=$db->query($selects);
            $rowss = $stmts->fetchAll(PDO::FETCH_CLASS);
            $stmts->closeCursor();
            foreach($rowss as $row1)
                $entries1["department"]=  GlobalLib::getName("sys_department",$row->sys_department_id,"name");
            $entries1["result"]=$row->count."/".$row1->count;


            $select1= "select name,code,count(name) count,Sum(amount) sums FROM doc_violations_handling mv
                        inner join master_violation dvh on mv.master_violation_id=dvh.id
                       WHERE (mv.is_delete = 0) and (month(date_violation) between '".$begin."' and '".$end."') and year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'  group by name";
            $stmt1=$db->query($select1);
            $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
            $stmt1->closeCursor();
            foreach($rows1 as $row2){
                $sum = $row2->sums;
                if(empty($sum))
                {
                    $sum = 0;
                }
                $entries[$row2->code]= $sum;
                $entries["result"]= $sum+$entries["result"];
                $entries1[$row2->code]= $row2->count;
                $i++;
            }
            $entries2[] = array($entries1,$entries);
        }
        return $i;
    }

    public function fetchAllDSBCKiemTraTheoQui($year, $sys_department_id = null){
        $db = Zend_Db_Table::getDefaultAdapter();
        $entriess1   = array("department"=>"","result"=>"");
        $entriess = array("result"=>"");
        $select="select code from master_violation";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
            $entriess[$row->code]="";
            $entriess1[$row->code]="";
        }
        $entries=$entriess;
        $entries1=$entriess1;
        $entries2 = array();
        if($sys_department_id === null)
            $select="select count(*) count,sys_department_id from info_schedule_check where year(date_check)='".$year."' group by sys_department_id";
        else
            $select="select count(*) count,sys_department_id from info_schedule_check where year(date_check)='".$year."' and sys_department_id='".$sys_department_id."' group by sys_department_id";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
            $entries=$entriess;
            $entries1=$entriess1;
            $selects="select count(*) count,sys_department_id from doc_violations_handling where year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'";
            $stmts=$db->query($selects);
            $rowss = $stmts->fetchAll(PDO::FETCH_CLASS);
            $stmts->closeCursor();
            foreach($rowss as $row1)
                $entries1["department"]=  GlobalLib::getName("sys_department",$row->sys_department_id,"name");
            $entries1["result"]=$row->count."/".$row1->count;


            $select1= "select name,code,count(name) count,Sum(amount) sums FROM doc_violations_handling mv
                        inner join master_violation dvh on mv.master_violation_id=dvh.id
                       WHERE (mv.is_delete = 0) and year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'  group by name";
            $stmt1=$db->query($select1);
            $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
            $stmt1->closeCursor();
            foreach($rows1 as $row2){
                $sum = $row2->sums;
                if(empty($sum))
                {
                    $sum = 0;
                }
                $entries[$row2->code]= $sum;
                $entries["result"]= $sum+$entries["result"];
                $entries1[$row2->code]= $row2->count;
            }
            $entries2[] = array($entries1,$entries);
        }
        return $entries2;
    }

    public function fetchRowCountAllDSBCKiemTraTheoQui($year, $sys_department_id = null){
        $db = Zend_Db_Table::getDefaultAdapter();
        $entriess1   = array("department"=>"","result"=>"");
        $entriess = array("result"=>"");
        $select="select code from master_violation";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        foreach($rows as $row){
            $entriess[$row->code]="";
            $entriess1[$row->code]="";
        }
        $entries=$entriess;
        $entries1=$entriess1;
        $entries2 = array();
        if($sys_department_id === null)
            $select="select count(*) count,sys_department_id from info_schedule_check where year(date_check)='".$year."' group by sys_department_id";
        else
            $select="select count(*) count,sys_department_id from info_schedule_check where year(date_check)='".$year."' and sys_department_id='".$sys_department_id."' group by sys_department_id";
        $stmt=$db->query($select);
        $rows = $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->closeCursor();
        $i = 0;
        foreach($rows as $row){
            $entries=$entriess;
            $entries1=$entriess1;
            $selects="select count(*) count,sys_department_id from doc_violations_handling where year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'";
            $stmts=$db->query($selects);
            $rowss = $stmts->fetchAll(PDO::FETCH_CLASS);
            $stmts->closeCursor();
            foreach($rowss as $row1)
                $entries1["department"]=  GlobalLib::getName("sys_department",$row->sys_department_id,"name");
            $entries1["result"]=$row->count."/".$row1->count;


            $select1= "select name,code,count(name) count,Sum(amount) sums FROM doc_violations_handling mv
                        inner join master_violation dvh on mv.master_violation_id=dvh.id
                       WHERE (mv.is_delete = 0) and year(date_violation)='".$year."' and sys_department_id='".$row->sys_department_id."'  group by name";
            $stmt1=$db->query($select1);
            $rows1 = $stmt1->fetchAll(PDO::FETCH_CLASS);
            $stmt1->closeCursor();
            foreach($rows1 as $row2){
                $sum = $row2->sums;
                if(empty($sum))
                {
                    $sum = 0;
                }
                $entries[$row2->code]= $sum;
                $entries["result"]= $sum+$entries["result"];
                $entries1[$row2->code]= $row2->count;
                $i++;
            }
            $entries2[] = array($entries1,$entries);
        }
        return $i;
    }
}
