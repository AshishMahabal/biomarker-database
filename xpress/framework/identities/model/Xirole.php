<?php


class XiroleVars {
	const OBJID = "objId";
	const NAME = "Name";
	const USERS = "Users";
}

class XiroleFactory {
	public static function Create($Name){
		$o = new Xirole();
		$o->Name = $Name;
		$o->save();
		return $o;
	}
	public static function Retrieve($value,$key = XiroleVars::OBJID,$fetchStrategy = XPress::FETCH_LOCAL) {
		$o = new Xirole();
		switch ($key) {
			case XiroleVars::OBJID:
				$o->objId = $value;
				$q = "SELECT * FROM `Xirole` WHERE `objId`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) {return false;}
				if (! is_array($data)) {return false;}
				$o->setName($data['Name'],false);
				return $o;
				break;
			case XiroleVars::NAME:
				$o->setName($value,false);
				$q = "SELECT * FROM `Xirole` WHERE `Name`=\"{$value}\" LIMIT 1";
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

class Xirole extends XPressObject {

	const _TYPE = "Xirole";
	public $Name = '';
	public $Users = array();


	public function __construct($objId = 0) {
		//echo "creating object of type Xirole<br/>";
		$this->objId = $objId;
	}

	// Accessor Functions
	public function getObjId() {
		 return $this->objId;
	}
	public function getName() {
		 return $this->Name;
	}
	public function getUsers() {
		if ($this->Users != array()) {
			return $this->Users;
		} else {
			$this->inflate(XiroleVars::USERS);
			return $this->Users;
		}
	}

	// Mutator Functions 
	public function setName($value,$bSave = true) {
		$this->Name = $value;
		if ($bSave){
			$this->save(XiroleVars::NAME);
		}
	}

	// API
	private function inflate($variableName) {
		switch ($variableName) {
			case "Users":
				// Inflate "Users":
				$q = "SELECT XiuserID AS objId FROM xr_Xiuser_Xirole WHERE XiroleID = {$this->objId} AND XiroleVar = \"Users\" ";
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
		$this->Users = array();
	}
	public function save($attr = null) {
		if ($this->objId == 0){
			// Insert a new object into the db
			$q = "INSERT INTO `Xirole` ";
			$q .= 'VALUES("","'.$this->Name.'") ';
			$r = XPress::getInstance()->getDatabase()->query($q);
			$this->objId = XPress::getInstance()->getDatabase()->getOne("SELECT LAST_INSERT_ID() FROM `Xirole`");
		} else {
			if ($attr != null) {
				// Update the given field of an existing object in the db
				$q = "UPDATE `Xirole` SET `{$attr}`=\"{$this->$attr}\" WHERE `objId` = $this->objId";
			} else {
				// Update all fields of an existing object in the db
				$q = "UPDATE `Xirole` SET ";
				$q .= "`objId`=\"{$this->objId}\","; 
				$q .= "`Name`=\"{$this->Name}\" ";
				$q .= "WHERE `objId` = $this->objId ";
			}
			$r = XPress::getInstance()->getDatabase()->query($q);
		}
	}
	public function delete() {
		//Delete this object's child objects

		//Intelligently unlink this object from any other objects
		$this->unlink(XiroleVars::USERS);

		//Signal objects that link to this object to unlink
		// (this covers the case in which a relationship is only 1-directional, where
		// this object has no idea its being pointed to by something)
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Xiuser_Xirole WHERE `XiroleID`={$this->objId}");

		//Delete object from the database
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM Xirole WHERE `objId` = $this->objId ");
		$this->deflate();
	}
	public function _getType(){
		return Xirole::_TYPE; //Xirole
	}
	public function link($variable,$remoteID,$remoteVar=''){
		switch ($variable){
			case "Users":
				$test = "SELECT COUNT(*) FROM Xiuser WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_Xiuser_Xirole WHERE XiroleID=$this->objId AND XiuserID=$remoteID ";
				$q0 = "INSERT INTO xr_Xiuser_Xirole (XiroleID,XiuserID,XiroleVar".(($remoteVar == '')? '' : ',XiuserVar').") VALUES($this->objId,$remoteID,\"Users\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_Xiuser_Xirole SET XiroleVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', XiuserVar="{$remoteVar}" ')." WHERE XiroleID=$this->objId AND XiuserID=$remoteID LIMIT 1 ";
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
				$q = "DELETE FROM xr_Xiuser_Xirole WHERE XiroleID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND XiuserID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND XiroleVar = \"Users\" ";
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