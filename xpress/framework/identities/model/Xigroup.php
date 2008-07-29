<?php


class XigroupVars {
	const OBJID = "objId";
	const NAME = "Name";
	const OBJECTCLASS = "ObjectClass";
	const USERS = "Users";
}

class XigroupFactory {
	public static function Create($Name){
		$o = new Xigroup();
		$o->Name = $Name;
		$o->save();
		return $o;
	}
	public static function Retrieve($value,$key = XigroupVars::OBJID,$fetchStrategy = XPress::FETCH_LOCAL) {
		$o = new Xigroup();
		switch ($key) {
			case XigroupVars::OBJID:
				$o->objId = $value;
				$q = "SELECT * FROM `Xigroup` WHERE `objId`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) {return false;}
				if (! is_array($data)) {return false;}
				$o->setName($data['Name'],false);
				$o->setObjectClass($data['ObjectClass'],false);
				return $o;
				break;
			case XigroupVars::NAME:
				$o->setName($value,false);
				$q = "SELECT * FROM `Xigroup` WHERE `Name`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) { return false;}
				if (! is_array($data)) {return false;}
				$o->setobjId($data['objId'],false);
				$o->setName($data['Name'],false);
				$o->setObjectClass($data['ObjectClass'],false);
				return $o;
				break;
			default:
				return false;
				break;
		}
	}
}

class Xigroup extends XPressObject {

	const _TYPE = "Xigroup";
	public $Name = '';
	public $ObjectClass = '';
	public $Users = array();


	public function __construct($objId = 0) {
		//echo "creating object of type Xigroup<br/>";
		$this->objId = $objId;
	}

	// Accessor Functions
	public function getObjId() {
		 return $this->objId;
	}
	public function getName() {
		 return $this->Name;
	}
	public function getObjectClass() {
		 return $this->ObjectClass;
	}
	public function getUsers() {
		if ($this->Users != array()) {
			return $this->Users;
		} else {
			$this->inflate(XigroupVars::USERS);
			return $this->Users;
		}
	}

	// Mutator Functions 
	public function setName($value,$bSave = true) {
		$this->Name = $value;
		if ($bSave){
			$this->save(XigroupVars::NAME);
		}
	}
	public function setObjectClass($value,$bSave = true) {
		$this->ObjectClass = $value;
		if ($bSave){
			$this->save(XigroupVars::OBJECTCLASS);
		}
	}

	// API
	private function inflate($variableName) {
		switch ($variableName) {
			case "Users":
				// Inflate "Users":
				$q = "SELECT XiuserID AS objId FROM xr_Xiuser_Xigroup WHERE XigroupID = {$this->objId} AND XigroupVar = \"Users\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->Users = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->Users[] = XiuserFactory::retrieve($id[objId]);
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
		$this->ObjectClass = '';
		$this->Users = array();
	}
	public function save($attr = null) {
		if ($this->objId == 0){
			// Insert a new object into the db
			$q = "INSERT INTO `Xigroup` ";
			$q .= 'VALUES("","'.$this->Name.'","'.$this->ObjectClass.'") ';
			$r = XPress::getInstance()->getDatabase()->query($q);
			$this->objId = XPress::getInstance()->getDatabase()->getOne("SELECT LAST_INSERT_ID() FROM `Xigroup`");
		} else {
			if ($attr != null) {
				// Update the given field of an existing object in the db
				$q = "UPDATE `Xigroup` SET `{$attr}`=\"{$this->$attr}\" WHERE `objId` = $this->objId";
			} else {
				// Update all fields of an existing object in the db
				$q = "UPDATE `Xigroup` SET ";
				$q .= "`objId`=\"{$this->objId}\","; 
				$q .= "`Name`=\"{$this->Name}\","; 
				$q .= "`ObjectClass`=\"{$this->ObjectClass}\" ";
				$q .= "WHERE `objId` = $this->objId ";
			}
			$r = XPress::getInstance()->getDatabase()->query($q);
		}
	}
	public function delete() {
		//Delete this object's child objects

		//Intelligently unlink this object from any other objects
		$this->unlink(XigroupVars::USERS);

		//Signal objects that link to this object to unlink
		// (this covers the case in which a relationship is only 1-directional, where
		// this object has no idea its being pointed to by something)
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Xiuser_Xigroup WHERE `XigroupID`={$this->objId}");

		//Delete object from the database
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM Xigroup WHERE `objId` = $this->objId ");
		$this->deflate();
	}
	public function _getType(){
		return Xigroup::_TYPE; //Xigroup
	}
	public function link($variable,$remoteID,$remoteVar=''){
		switch ($variable){
			case "Users":
				$test = "SELECT COUNT(*) FROM Xiuser WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_Xiuser_Xigroup WHERE XigroupID=$this->objId AND XiuserID=$remoteID ";
				$q0 = "INSERT INTO xr_Xiuser_Xigroup (XigroupID,XiuserID,XigroupVar".(($remoteVar == '')? '' : ',XiuserVar').") VALUES($this->objId,$remoteID,\"Users\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_Xiuser_Xigroup SET XigroupVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', XiuserVar="{$remoteVar}" ')." WHERE XigroupID=$this->objId AND XiuserID=$remoteID LIMIT 1 ";
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
			case "Users":
				$q = "DELETE FROM xr_Xiuser_Xigroup WHERE XigroupID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND XiuserID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND XigroupVar = \"Users\" ";
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