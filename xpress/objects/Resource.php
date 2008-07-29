<?php


class ResourceVars {
	const OBJID = "objId";
	const NAME = "Name";
	const URL = "URL";
	const BIOMARKERS = "Biomarkers";
	const BIOMARKERORGANS = "BiomarkerOrgans";
	const BIOMARKERORGANSTUDIES = "BiomarkerOrganStudies";
	const BIOMARKERSTUDIES = "BiomarkerStudies";
	const STUDIES = "Studies";
}

class ResourceFactory {
	public static function Create(){
		$o = new Resource();
		$o->save();
		return $o;
	}
	public static function Retrieve($value,$key = ResourceVars::OBJID,$fetchStrategy = XPress::FETCH_LOCAL) {
		$o = new Resource();
		switch ($key) {
			case ResourceVars::OBJID:
				$o->objId = $value;
				$q = "SELECT * FROM `Resource` WHERE `objId`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) {return false;}
				if (! is_array($data)) {return false;}
				$o->setName($data['Name'],false);
				$o->setURL($data['URL'],false);
				return $o;
				break;
			default:
				return false;
				break;
		}
	}
}

class Resource extends XPressObject {

	const _TYPE = "Resource";
	public $Name = '';
	public $URL = '';
	public $Biomarkers = array();
	public $BiomarkerOrgans = array();
	public $BiomarkerOrganStudies = array();
	public $BiomarkerStudies = array();
	public $Studies = array();


	public function __construct($objId = 0) {
		//echo "creating object of type Resource<br/>";
		$this->objId = $objId;
	}

	// Accessor Functions
	public function getObjId() {
		 return $this->objId;
	}
	public function getName() {
		 return $this->Name;
	}
	public function getURL() {
		 return $this->URL;
	}
	public function getBiomarkers() {
		if ($this->Biomarkers != array()) {
			return $this->Biomarkers;
		} else {
			$this->inflate(ResourceVars::BIOMARKERS);
			return $this->Biomarkers;
		}
	}
	public function getBiomarkerOrgans() {
		if ($this->BiomarkerOrgans != array()) {
			return $this->BiomarkerOrgans;
		} else {
			$this->inflate(ResourceVars::BIOMARKERORGANS);
			return $this->BiomarkerOrgans;
		}
	}
	public function getBiomarkerOrganStudies() {
		if ($this->BiomarkerOrganStudies != array()) {
			return $this->BiomarkerOrganStudies;
		} else {
			$this->inflate(ResourceVars::BIOMARKERORGANSTUDIES);
			return $this->BiomarkerOrganStudies;
		}
	}
	public function getBiomarkerStudies() {
		if ($this->BiomarkerStudies != array()) {
			return $this->BiomarkerStudies;
		} else {
			$this->inflate(ResourceVars::BIOMARKERSTUDIES);
			return $this->BiomarkerStudies;
		}
	}
	public function getStudies() {
		if ($this->Studies != array()) {
			return $this->Studies;
		} else {
			$this->inflate(ResourceVars::STUDIES);
			return $this->Studies;
		}
	}

	// Mutator Functions 
	public function setName($value,$bSave = true) {
		$this->Name = $value;
		if ($bSave){
			$this->save(ResourceVars::NAME);
		}
	}
	public function setURL($value,$bSave = true) {
		$this->URL = $value;
		if ($bSave){
			$this->save(ResourceVars::URL);
		}
	}

	// API
	private function inflate($variableName) {
		switch ($variableName) {
			case "Biomarkers":
				// Inflate "Biomarkers":
				$q = "SELECT BiomarkerID AS objId FROM xr_Biomarker_Resource WHERE ResourceID = {$this->objId} AND ResourceVar = \"Biomarkers\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->Biomarkers = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->Biomarkers[] = BiomarkerFactory::retrieve($id[objId]);
				}
				break;
			case "BiomarkerStudies":
				// Inflate "BiomarkerStudies":
				$q = "SELECT BiomarkerStudyDataID AS objId FROM xr_BiomarkerStudyData_Resource WHERE ResourceID = {$this->objId} AND ResourceVar = \"BiomarkerStudies\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->BiomarkerStudies = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->BiomarkerStudies[] = BiomarkerStudyDataFactory::retrieve($id[objId]);
				}
				break;
			case "BiomarkerOrgans":
				// Inflate "BiomarkerOrgans":
				$q = "SELECT BiomarkerOrganDataID AS objId FROM xr_BiomarkerOrganData_Resource WHERE ResourceID = {$this->objId} AND ResourceVar = \"BiomarkerOrgans\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->BiomarkerOrgans = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->BiomarkerOrgans[] = BiomarkerOrganDataFactory::retrieve($id[objId]);
				}
				break;
			case "BiomarkerOrganStudies":
				// Inflate "BiomarkerOrganStudies":
				$q = "SELECT BiomarkerOrganStudyDataID AS objId FROM xr_BiomarkerOrganStudyData_Resource WHERE ResourceID = {$this->objId} AND ResourceVar = \"BiomarkerOrganStudies\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->BiomarkerOrganStudies = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->BiomarkerOrganStudies[] = BiomarkerOrganStudyDataFactory::retrieve($id[objId]);
				}
				break;
			case "Studies":
				// Inflate "Studies":
				$q = "SELECT StudyID AS objId FROM xr_Study_Resource WHERE ResourceID = {$this->objId} AND ResourceVar = \"Studies\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->Studies = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->Studies[] = StudyFactory::retrieve($id[objId]);
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
		$this->URL = '';
		$this->Biomarkers = array();
		$this->BiomarkerOrgans = array();
		$this->BiomarkerOrganStudies = array();
		$this->BiomarkerStudies = array();
		$this->Studies = array();
	}
	public function save($attr = null) {
		if ($this->objId == 0){
			// Insert a new object into the db
			$q = "INSERT INTO `Resource` ";
			$q .= 'VALUES("","'.$this->Name.'","'.$this->URL.'") ';
			$r = XPress::getInstance()->getDatabase()->query($q);
			$this->objId = XPress::getInstance()->getDatabase()->getOne("SELECT LAST_INSERT_ID() FROM `Resource`");
		} else {
			if ($attr != null) {
				// Update the given field of an existing object in the db
				$q = "UPDATE `Resource` SET `{$attr}`=\"{$this->$attr}\" WHERE `objId` = $this->objId";
			} else {
				// Update all fields of an existing object in the db
				$q = "UPDATE `Resource` SET ";
				$q .= "`objId`=\"{$this->objId}\","; 
				$q .= "`Name`=\"{$this->Name}\","; 
				$q .= "`URL`=\"{$this->URL}\" ";
				$q .= "WHERE `objId` = $this->objId ";
			}
			$r = XPress::getInstance()->getDatabase()->query($q);
		}
	}
	public function delete() {
		//Delete this object's child objects

		//Intelligently unlink this object from any other objects
		$this->unlink(ResourceVars::BIOMARKERS);
		$this->unlink(ResourceVars::BIOMARKERORGANS);
		$this->unlink(ResourceVars::BIOMARKERORGANSTUDIES);
		$this->unlink(ResourceVars::BIOMARKERSTUDIES);
		$this->unlink(ResourceVars::STUDIES);

		//Signal objects that link to this object to unlink
		// (this covers the case in which a relationship is only 1-directional, where
		// this object has no idea its being pointed to by something)
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Biomarker_Resource WHERE `ResourceID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerStudyData_Resource WHERE `ResourceID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerOrganData_Resource WHERE `ResourceID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerOrganStudyData_Resource WHERE `ResourceID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Study_Resource WHERE `ResourceID`={$this->objId}");

		//Delete object from the database
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM Resource WHERE `objId` = $this->objId ");
		$this->deflate();
	}
	public function _getType(){
		return Resource::_TYPE; //Resource
	}
	public function link($variable,$remoteID,$remoteVar=''){
		switch ($variable){
			case "Biomarkers":
				$test = "SELECT COUNT(*) FROM Biomarker WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_Biomarker_Resource WHERE ResourceID=$this->objId AND BiomarkerID=$remoteID ";
				$q0 = "INSERT INTO xr_Biomarker_Resource (ResourceID,BiomarkerID,ResourceVar".(($remoteVar == '')? '' : ',BiomarkerVar').") VALUES($this->objId,$remoteID,\"Biomarkers\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_Biomarker_Resource SET ResourceVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerVar="{$remoteVar}" ')." WHERE ResourceID=$this->objId AND BiomarkerID=$remoteID LIMIT 1 ";
				break;
			case "BiomarkerStudies":
				$test = "SELECT COUNT(*) FROM BiomarkerStudyData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerStudyData_Resource WHERE ResourceID=$this->objId AND BiomarkerStudyDataID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerStudyData_Resource (ResourceID,BiomarkerStudyDataID,ResourceVar".(($remoteVar == '')? '' : ',BiomarkerStudyDataVar').") VALUES($this->objId,$remoteID,\"BiomarkerStudies\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerStudyData_Resource SET ResourceVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerStudyDataVar="{$remoteVar}" ')." WHERE ResourceID=$this->objId AND BiomarkerStudyDataID=$remoteID LIMIT 1 ";
				break;
			case "BiomarkerOrgans":
				$test = "SELECT COUNT(*) FROM BiomarkerOrganData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerOrganData_Resource WHERE ResourceID=$this->objId AND BiomarkerOrganDataID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerOrganData_Resource (ResourceID,BiomarkerOrganDataID,ResourceVar".(($remoteVar == '')? '' : ',BiomarkerOrganDataVar').") VALUES($this->objId,$remoteID,\"BiomarkerOrgans\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerOrganData_Resource SET ResourceVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerOrganDataVar="{$remoteVar}" ')." WHERE ResourceID=$this->objId AND BiomarkerOrganDataID=$remoteID LIMIT 1 ";
				break;
			case "BiomarkerOrganStudies":
				$test = "SELECT COUNT(*) FROM BiomarkerOrganStudyData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerOrganStudyData_Resource WHERE ResourceID=$this->objId AND BiomarkerOrganStudyDataID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerOrganStudyData_Resource (ResourceID,BiomarkerOrganStudyDataID,ResourceVar".(($remoteVar == '')? '' : ',BiomarkerOrganStudyDataVar').") VALUES($this->objId,$remoteID,\"BiomarkerOrganStudies\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerOrganStudyData_Resource SET ResourceVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerOrganStudyDataVar="{$remoteVar}" ')." WHERE ResourceID=$this->objId AND BiomarkerOrganStudyDataID=$remoteID LIMIT 1 ";
				break;
			case "Studies":
				$test = "SELECT COUNT(*) FROM Study WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_Study_Resource WHERE ResourceID=$this->objId AND StudyID=$remoteID ";
				$q0 = "INSERT INTO xr_Study_Resource (ResourceID,StudyID,ResourceVar".(($remoteVar == '')? '' : ',StudyVar').") VALUES($this->objId,$remoteID,\"Studies\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_Study_Resource SET ResourceVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', StudyVar="{$remoteVar}" ')." WHERE ResourceID=$this->objId AND StudyID=$remoteID LIMIT 1 ";
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
			case "Biomarkers":
				$q = "DELETE FROM xr_Biomarker_Resource WHERE ResourceID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND ResourceVar = \"Biomarkers\" ";
				break;
			case "BiomarkerStudies":
				$q = "DELETE FROM xr_BiomarkerStudyData_Resource WHERE ResourceID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerStudyDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND ResourceVar = \"BiomarkerStudies\" ";
				break;
			case "BiomarkerOrgans":
				$q = "DELETE FROM xr_BiomarkerOrganData_Resource WHERE ResourceID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerOrganDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND ResourceVar = \"BiomarkerOrgans\" ";
				break;
			case "BiomarkerOrganStudies":
				$q = "DELETE FROM xr_BiomarkerOrganStudyData_Resource WHERE ResourceID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerOrganStudyDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND ResourceVar = \"BiomarkerOrganStudies\" ";
				break;
			case "Studies":
				$q = "DELETE FROM xr_Study_Resource WHERE ResourceID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND StudyID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND ResourceVar = \"Studies\" ";
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