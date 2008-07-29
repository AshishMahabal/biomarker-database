<?php


class OrganVars {
	const OBJID = "objId";
	const NAME = "Name";
	const ORGANDATAS = "OrganDatas";
}

class OrganFactory {
	public static function Create($Name){
		$o = new Organ();
		$o->Name = $Name;
		$o->save();
		return $o;
	}
	public static function Retrieve($value,$key = OrganVars::OBJID,$fetchStrategy = XPress::FETCH_LOCAL) {
		$o = new Organ();
		switch ($key) {
			case OrganVars::OBJID:
				$o->objId = $value;
				$q = "SELECT * FROM `Organ` WHERE `objId`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) {return false;}
				if (! is_array($data)) {return false;}
				$o->setName($data['Name'],false);
				return $o;
				break;
			case OrganVars::NAME:
				$o->setName($value,false);
				$q = "SELECT * FROM `Organ` WHERE `Name`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) { return false;}
				if (! is_array($data)) {return false;}
				$o->setobjId($data['objId'],false);
				$o->setName($data['Name'],false);
				return $o;
				break;
			default:
				return false;
				break;
		}
	}
}

class Organ extends XPressObject {

	const _TYPE = "Organ";
	public $Name = '';
	public $OrganDatas = array();


	public function __construct($objId = 0) {
		//echo "creating object of type Organ<br/>";
		$this->objId = $objId;
	}

	// Accessor Functions
	public function getObjId() {
		 return $this->objId;
	}
	public function getName() {
		 return $this->Name;
	}
	public function getOrganDatas() {
		if ($this->OrganDatas != array()) {
			return $this->OrganDatas;
		} else {
			$this->inflate(OrganVars::ORGANDATAS);
			return $this->OrganDatas;
		}
	}

	// Mutator Functions 
	public function setName($value,$bSave = true) {
		$this->Name = $value;
		if ($bSave){
			$this->save(OrganVars::NAME);
		}
	}

	// API
	private function inflate($variableName) {
		switch ($variableName) {
			case "OrganDatas":
				// Inflate "OrganDatas":
				$q = "SELECT BiomarkerOrganDataID AS objId FROM xr_BiomarkerOrganData_Organ WHERE OrganID = {$this->objId} AND OrganVar = \"OrganDatas\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->OrganDatas = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->OrganDatas[] = BiomarkerOrganDataFactory::retrieve($id[objId]);
				}
				break;
			default:
				return false;
		}
		return true;
	}
	public function deflate(){
		// reset all member variables to initial settings
		$this->objId = '';
		$this->Name = '';
		$this->OrganDatas = array();
	}
	public function save($attr = null) {
		if ($this->objId == 0){
			// Insert a new object into the db
			$q = "INSERT INTO `Organ` ";
			$q .= 'VALUES("","'.$this->Name.'") ';
			$r = XPress::getInstance()->getDatabase()->query($q);
			$this->objId = XPress::getInstance()->getDatabase()->getOne("SELECT LAST_INSERT_ID() FROM `Organ`");
		} else {
			if ($attr != null) {
				// Update the given field of an existing object in the db
				$q = "UPDATE `Organ` SET `{$attr}`=\"{$this->$attr}\" WHERE `objId` = $this->objId";
			} else {
				// Update all fields of an existing object in the db
				$q = "UPDATE `Organ` SET ";
				$q .= "`objId`=\"{$this->objId}\","; 
				$q .= "`Name`=\"{$this->Name}\" ";
				$q .= "WHERE `objId` = $this->objId ";
			}
			$r = XPress::getInstance()->getDatabase()->query($q);
		}
	}
	public function delete() {
		//Delete this object's child objects
		foreach ($this->getOrganDatas() as $obj){
			$obj->delete();
		}

		//Intelligently unlink this object from any other objects
		$this->unlink(OrganVars::ORGANDATAS);

		//Signal objects that link to this object to unlink
		// (this covers the case in which a relationship is only 1-directional, where
		// this object has no idea its being pointed to by something)
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerOrganData_Organ WHERE `OrganID`={$this->objId}");

		//Delete object from the database
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM Organ WHERE `objId` = $this->objId ");
		$this->deflate();
	}
	public function _getType(){
		return Organ::_TYPE; //Organ
	}
	public function link($variable,$remoteID,$remoteVar=''){
		switch ($variable){
			case "OrganDatas":
				$test = "SELECT COUNT(*) FROM BiomarkerOrganData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerOrganData_Organ WHERE OrganID=$this->objId AND BiomarkerOrganDataID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerOrganData_Organ (OrganID,BiomarkerOrganDataID,OrganVar".(($remoteVar == '')? '' : ',BiomarkerOrganDataVar').") VALUES($this->objId,$remoteID,\"OrganDatas\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerOrganData_Organ SET OrganVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerOrganDataVar="{$remoteVar}" ')." WHERE OrganID=$this->objId AND BiomarkerOrganDataID=$remoteID LIMIT 1 ";
				break;
			default:
				break;
		}
		if (1 != XPress::getInstance()->getDatabase()->getOne($test)) {
			return false; // The requested remote id does not exist!
		}
		$count  = XPress::getInstance()->getDatabase()->getOne($q);
		if ($count == 0){
			XPress::getInstance()->getDatabase()->query($q0);
		} else {
			XPress::getInstance()->getDatabase()->query($q1);
		}
		return true;
	}
	public function unlink($variable,$remoteIDs = ''){
		switch ($variable){
			case "OrganDatas":
				$q = "DELETE FROM xr_BiomarkerOrganData_Organ WHERE OrganID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerOrganDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND OrganVar = \"OrganDatas\" ";
				break;
			default:
				break;
		}
		$r  = XPress::getInstance()->getDatabase()->query($q);
		return true;
	}
	public function equals($objArray){
		if ($objArray == null){return false;}
		//print_r($objArray);
		foreach ($objArray as $obj){
			//echo "::EQUALS:: comparing {$this->_getType()} WITH {$obj->_getType()} &nbsp;<br/>";
			// Check object types first
			if ($this->_getType() == $obj->_getType()){
				// Check objId next
				if ($this->objId != $obj->objId){continue;}
				return true;
			}
		}
		return false;
	}
	public function toJSON(){
		return json_encode($this);
	}
	public function toRDF($namespace,$urlBase) {
		return "";
	}
	public function toRDFStub($namespace,$urlBase) {
		return "";
	}

	// API Extensions 
	// -@-	// -@-
	// End API Extensions --
}

?>