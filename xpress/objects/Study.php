<?php


class StudyVars {
	const OBJID = "objId";
	const EDRNID = "EDRNID";
	const FHCRCID = "FHCRCID";
	const DMCCID = "DMCCID";
	const ISEDRN = "IsEDRN";
	const TITLE = "Title";
	const STUDYABSTRACT = "StudyAbstract";
	const BIOMARKERPOPULATIONCHARACTERISTICS = "BiomarkerPopulationCharacteristics";
	const BPCDESCRIPTION = "BPCDescription";
	const DESIGN = "Design";
	const DESIGNDESCRIPTION = "DesignDescription";
	const BIOMARKERSTUDYTYPE = "BiomarkerStudyType";
	const BIOMARKERS = "Biomarkers";
	const BIOMARKERORGANS = "BiomarkerOrgans";
	const BIOMARKERORGANDATAS = "BiomarkerOrganDatas";
	const PUBLICATIONS = "Publications";
	const RESOURCES = "Resources";
}

class StudyFactory {
	public static function Create($Title){
		$o = new Study();
		$o->Title = $Title;
		$o->save();
		return $o;
	}
	public static function Retrieve($value,$key = StudyVars::OBJID,$fetchStrategy = XPress::FETCH_LOCAL) {
		$o = new Study();
		switch ($key) {
			case StudyVars::OBJID:
				$o->objId = $value;
				$q = "SELECT * FROM `Study` WHERE `objId`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) {return false;}
				if (! is_array($data)) {return false;}
				$o->setEDRNID($data['EDRNID'],false);
				$o->setFHCRCID($data['FHCRCID'],false);
				$o->setDMCCID($data['DMCCID'],false);
				$o->setIsEDRN($data['IsEDRN'],false);
				$o->setTitle($data['Title'],false);
				$o->setStudyAbstract($data['StudyAbstract'],false);
				$o->setBiomarkerPopulationCharacteristics($data['BiomarkerPopulationCharacteristics'],false);
				$o->setBPCDescription($data['BPCDescription'],false);
				$o->setDesign($data['Design'],false);
				$o->setDesignDescription($data['DesignDescription'],false);
				$o->setBiomarkerStudyType($data['BiomarkerStudyType'],false);
				return $o;
				break;
			case StudyVars::TITLE:
				$o->setTitle($value,false);
				$q = "SELECT * FROM `Study` WHERE `Title`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) { return false;}
				if (! is_array($data)) {return false;}
				$o->setobjId($data['objId'],false);
				$o->setEDRNID($data['EDRNID'],false);
				$o->setFHCRCID($data['FHCRCID'],false);
				$o->setDMCCID($data['DMCCID'],false);
				$o->setIsEDRN($data['IsEDRN'],false);
				$o->setTitle($data['Title'],false);
				$o->setStudyAbstract($data['StudyAbstract'],false);
				$o->setBiomarkerPopulationCharacteristics($data['BiomarkerPopulationCharacteristics'],false);
				$o->setBPCDescription($data['BPCDescription'],false);
				$o->setDesign($data['Design'],false);
				$o->setDesignDescription($data['DesignDescription'],false);
				$o->setBiomarkerStudyType($data['BiomarkerStudyType'],false);
				return $o;
				break;
			default:
				return false;
				break;
		}
	}
}

class Study extends XPressObject {

	const _TYPE = "Study";
	public $BiomarkerPopulationCharacteristicsEnumValues = array("Case/Control","Longitudinal","Randomized");
	public $DesignEnumValues = array("Retrospective","Prospective Analysis","Cross Sectional");
	public $BiomarkerStudyTypeEnumValues = array("Registered","Unregistered");
	public $EDRNID = '';
	public $FHCRCID = '';
	public $DMCCID = '';
	public $IsEDRN = '';
	public $Title = '';
	public $StudyAbstract = '';
	public $BiomarkerPopulationCharacteristics = '';
	public $BPCDescription = '';
	public $Design = '';
	public $DesignDescription = '';
	public $BiomarkerStudyType = '';
	public $Biomarkers = array();
	public $BiomarkerOrgans = array();
	public $BiomarkerOrganDatas = array();
	public $Publications = array();
	public $Resources = array();


	public function __construct($objId = 0) {
		//echo "creating object of type Study<br/>";
		$this->objId = $objId;
	}

	// Accessor Functions
	public function getObjId() {
		 return $this->objId;
	}
	public function getEDRNID() {
		 return $this->EDRNID;
	}
	public function getFHCRCID() {
		 return $this->FHCRCID;
	}
	public function getDMCCID() {
		 return $this->DMCCID;
	}
	public function getIsEDRN() {
		 return $this->IsEDRN;
	}
	public function getTitle() {
		 return $this->Title;
	}
	public function getStudyAbstract() {
		 return $this->StudyAbstract;
	}
	public function getBiomarkerPopulationCharacteristics() {
		 return $this->BiomarkerPopulationCharacteristics;
	}
	public function getBPCDescription() {
		 return $this->BPCDescription;
	}
	public function getDesign() {
		 return $this->Design;
	}
	public function getDesignDescription() {
		 return $this->DesignDescription;
	}
	public function getBiomarkerStudyType() {
		 return $this->BiomarkerStudyType;
	}
	public function getBiomarkers() {
		if ($this->Biomarkers != array()) {
			return $this->Biomarkers;
		} else {
			$this->inflate(StudyVars::BIOMARKERS);
			return $this->Biomarkers;
		}
	}
	public function getBiomarkerOrgans() {
		if ($this->BiomarkerOrgans != array()) {
			return $this->BiomarkerOrgans;
		} else {
			$this->inflate(StudyVars::BIOMARKERORGANS);
			return $this->BiomarkerOrgans;
		}
	}
	public function getBiomarkerOrganDatas() {
		if ($this->BiomarkerOrganDatas != array()) {
			return $this->BiomarkerOrganDatas;
		} else {
			$this->inflate(StudyVars::BIOMARKERORGANDATAS);
			return $this->BiomarkerOrganDatas;
		}
	}
	public function getPublications() {
		if ($this->Publications != array()) {
			return $this->Publications;
		} else {
			$this->inflate(StudyVars::PUBLICATIONS);
			return $this->Publications;
		}
	}
	public function getResources() {
		if ($this->Resources != array()) {
			return $this->Resources;
		} else {
			$this->inflate(StudyVars::RESOURCES);
			return $this->Resources;
		}
	}

	// Mutator Functions 
	public function setEDRNID($value,$bSave = true) {
		$this->EDRNID = $value;
		if ($bSave){
			$this->save(StudyVars::EDRNID);
		}
	}
	public function setFHCRCID($value,$bSave = true) {
		$this->FHCRCID = $value;
		if ($bSave){
			$this->save(StudyVars::FHCRCID);
		}
	}
	public function setDMCCID($value,$bSave = true) {
		$this->DMCCID = $value;
		if ($bSave){
			$this->save(StudyVars::DMCCID);
		}
	}
	public function setIsEDRN($value,$bSave = true) {
		$this->IsEDRN = $value;
		if ($bSave){
			$this->save(StudyVars::ISEDRN);
		}
	}
	public function setTitle($value,$bSave = true) {
		$this->Title = $value;
		if ($bSave){
			$this->save(StudyVars::TITLE);
		}
	}
	public function setStudyAbstract($value,$bSave = true) {
		$this->StudyAbstract = $value;
		if ($bSave){
			$this->save(StudyVars::STUDYABSTRACT);
		}
	}
	public function setBiomarkerPopulationCharacteristics($value,$bSave = true) {
		$this->BiomarkerPopulationCharacteristics = $value;
		if ($bSave){
			$this->save(StudyVars::BIOMARKERPOPULATIONCHARACTERISTICS);
		}
	}
	public function setBPCDescription($value,$bSave = true) {
		$this->BPCDescription = $value;
		if ($bSave){
			$this->save(StudyVars::BPCDESCRIPTION);
		}
	}
	public function setDesign($value,$bSave = true) {
		$this->Design = $value;
		if ($bSave){
			$this->save(StudyVars::DESIGN);
		}
	}
	public function setDesignDescription($value,$bSave = true) {
		$this->DesignDescription = $value;
		if ($bSave){
			$this->save(StudyVars::DESIGNDESCRIPTION);
		}
	}
	public function setBiomarkerStudyType($value,$bSave = true) {
		$this->BiomarkerStudyType = $value;
		if ($bSave){
			$this->save(StudyVars::BIOMARKERSTUDYTYPE);
		}
	}

	// API
	private function inflate($variableName) {
		switch ($variableName) {
			case "Biomarkers":
				// Inflate "Biomarkers":
				$q = "SELECT BiomarkerStudyDataID AS objId FROM xr_BiomarkerStudyData_Study WHERE StudyID = {$this->objId} AND StudyVar = \"Biomarkers\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->Biomarkers = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->Biomarkers[] = BiomarkerStudyDataFactory::retrieve($id[objId]);
				}
				break;
			case "BiomarkerOrganDatas":
				// Inflate "BiomarkerOrganDatas":
				$q = "SELECT BiomarkerOrganStudyDataID AS objId FROM xr_BiomarkerOrganStudyData_Study WHERE StudyID = {$this->objId} AND StudyVar = \"BiomarkerOrganDatas\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->BiomarkerOrganDatas = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->BiomarkerOrganDatas[] = BiomarkerOrganStudyDataFactory::retrieve($id[objId]);
				}
				break;
			case "BiomarkerOrgans":
				// Inflate "BiomarkerOrgans":
				$q = "SELECT BiomarkerOrganDataID AS objId FROM xr_Study_BiomarkerOrganData WHERE StudyID = {$this->objId} AND StudyVar = \"BiomarkerOrgans\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->BiomarkerOrgans = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->BiomarkerOrgans[] = BiomarkerOrganDataFactory::retrieve($id[objId]);
				}
				break;
			case "Publications":
				// Inflate "Publications":
				$q = "SELECT PublicationID AS objId FROM xr_Study_Publication WHERE StudyID = {$this->objId} AND StudyVar = \"Publications\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->Publications = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->Publications[] = PublicationFactory::retrieve($id[objId]);
				}
				break;
			case "Resources":
				// Inflate "Resources":
				$q = "SELECT ResourceID AS objId FROM xr_Study_Resource WHERE StudyID = {$this->objId} AND StudyVar = \"Resources\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->Resources = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->Resources[] = ResourceFactory::retrieve($id[objId]);
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
		$this->EDRNID = '';
		$this->FHCRCID = '';
		$this->DMCCID = '';
		$this->IsEDRN = '';
		$this->Title = '';
		$this->StudyAbstract = '';
		$this->BiomarkerPopulationCharacteristics = '';
		$this->BPCDescription = '';
		$this->Design = '';
		$this->DesignDescription = '';
		$this->BiomarkerStudyType = '';
		$this->Biomarkers = array();
		$this->BiomarkerOrgans = array();
		$this->BiomarkerOrganDatas = array();
		$this->Publications = array();
		$this->Resources = array();
	}
	public function save($attr = null) {
		if ($this->objId == 0){
			// Insert a new object into the db
			$q = "INSERT INTO `Study` ";
			$q .= 'VALUES("","'.$this->EDRNID.'","'.$this->FHCRCID.'","'.$this->DMCCID.'","'.$this->IsEDRN.'","'.$this->Title.'","'.$this->StudyAbstract.'","'.$this->BiomarkerPopulationCharacteristics.'","'.$this->BPCDescription.'","'.$this->Design.'","'.$this->DesignDescription.'","'.$this->BiomarkerStudyType.'") ';
			$r = XPress::getInstance()->getDatabase()->query($q);
			$this->objId = XPress::getInstance()->getDatabase()->getOne("SELECT LAST_INSERT_ID() FROM `Study`");
		} else {
			if ($attr != null) {
				// Update the given field of an existing object in the db
				$q = "UPDATE `Study` SET `{$attr}`=\"{$this->$attr}\" WHERE `objId` = $this->objId";
			} else {
				// Update all fields of an existing object in the db
				$q = "UPDATE `Study` SET ";
				$q .= "`objId`=\"{$this->objId}\","; 
				$q .= "`EDRNID`=\"{$this->EDRNID}\","; 
				$q .= "`FHCRCID`=\"{$this->FHCRCID}\","; 
				$q .= "`DMCCID`=\"{$this->DMCCID}\","; 
				$q .= "`IsEDRN`=\"{$this->IsEDRN}\","; 
				$q .= "`Title`=\"{$this->Title}\","; 
				$q .= "`StudyAbstract`=\"{$this->StudyAbstract}\","; 
				$q .= "`BiomarkerPopulationCharacteristics`=\"{$this->BiomarkerPopulationCharacteristics}\","; 
				$q .= "`BPCDescription`=\"{$this->BPCDescription}\","; 
				$q .= "`Design`=\"{$this->Design}\","; 
				$q .= "`DesignDescription`=\"{$this->DesignDescription}\","; 
				$q .= "`BiomarkerStudyType`=\"{$this->BiomarkerStudyType}\" ";
				$q .= "WHERE `objId` = $this->objId ";
			}
			$r = XPress::getInstance()->getDatabase()->query($q);
		}
	}
	public function delete() {
		//Delete this object's child objects
		foreach ($this->getBiomarkers() as $obj){
			$obj->delete();
		}
		foreach ($this->getBiomarkerOrgans() as $obj){
			$obj->delete();
		}
		foreach ($this->getBiomarkerOrganDatas() as $obj){
			$obj->delete();
		}

		//Intelligently unlink this object from any other objects
		$this->unlink(StudyVars::BIOMARKERS);
		$this->unlink(StudyVars::BIOMARKERORGANS);
		$this->unlink(StudyVars::BIOMARKERORGANDATAS);
		$this->unlink(StudyVars::PUBLICATIONS);
		$this->unlink(StudyVars::RESOURCES);

		//Signal objects that link to this object to unlink
		// (this covers the case in which a relationship is only 1-directional, where
		// this object has no idea its being pointed to by something)
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerStudyData_Study WHERE `StudyID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerOrganStudyData_Study WHERE `StudyID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Study_BiomarkerOrganData WHERE `StudyID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Study_Publication WHERE `StudyID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Study_Resource WHERE `StudyID`={$this->objId}");

		//Delete object from the database
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM Study WHERE `objId` = $this->objId ");
		$this->deflate();
	}
	public function _getType(){
		return Study::_TYPE; //Study
	}
	public function link($variable,$remoteID,$remoteVar=''){
		switch ($variable){
			case "Biomarkers":
				$test = "SELECT COUNT(*) FROM BiomarkerStudyData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerStudyData_Study WHERE StudyID=$this->objId AND BiomarkerStudyDataID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerStudyData_Study (StudyID,BiomarkerStudyDataID,StudyVar".(($remoteVar == '')? '' : ',BiomarkerStudyDataVar').") VALUES($this->objId,$remoteID,\"Biomarkers\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerStudyData_Study SET StudyVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerStudyDataVar="{$remoteVar}" ')." WHERE StudyID=$this->objId AND BiomarkerStudyDataID=$remoteID LIMIT 1 ";
				break;
			case "BiomarkerOrganDatas":
				$test = "SELECT COUNT(*) FROM BiomarkerOrganStudyData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerOrganStudyData_Study WHERE StudyID=$this->objId AND BiomarkerOrganStudyDataID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerOrganStudyData_Study (StudyID,BiomarkerOrganStudyDataID,StudyVar".(($remoteVar == '')? '' : ',BiomarkerOrganStudyDataVar').") VALUES($this->objId,$remoteID,\"BiomarkerOrganDatas\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerOrganStudyData_Study SET StudyVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerOrganStudyDataVar="{$remoteVar}" ')." WHERE StudyID=$this->objId AND BiomarkerOrganStudyDataID=$remoteID LIMIT 1 ";
				break;
			case "BiomarkerOrgans":
				$test = "SELECT COUNT(*) FROM BiomarkerOrganData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_Study_BiomarkerOrganData WHERE StudyID=$this->objId AND BiomarkerOrganDataID=$remoteID ";
				$q0 = "INSERT INTO xr_Study_BiomarkerOrganData (StudyID,BiomarkerOrganDataID,StudyVar".(($remoteVar == '')? '' : ',BiomarkerOrganDataVar').") VALUES($this->objId,$remoteID,\"BiomarkerOrgans\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_Study_BiomarkerOrganData SET StudyVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerOrganDataVar="{$remoteVar}" ')." WHERE StudyID=$this->objId AND BiomarkerOrganDataID=$remoteID LIMIT 1 ";
				break;
			case "Publications":
				$test = "SELECT COUNT(*) FROM Publication WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_Study_Publication WHERE StudyID=$this->objId AND PublicationID=$remoteID ";
				$q0 = "INSERT INTO xr_Study_Publication (StudyID,PublicationID,StudyVar".(($remoteVar == '')? '' : ',PublicationVar').") VALUES($this->objId,$remoteID,\"Publications\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_Study_Publication SET StudyVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', PublicationVar="{$remoteVar}" ')." WHERE StudyID=$this->objId AND PublicationID=$remoteID LIMIT 1 ";
				break;
			case "Resources":
				$test = "SELECT COUNT(*) FROM Resource WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_Study_Resource WHERE StudyID=$this->objId AND ResourceID=$remoteID ";
				$q0 = "INSERT INTO xr_Study_Resource (StudyID,ResourceID,StudyVar".(($remoteVar == '')? '' : ',ResourceVar').") VALUES($this->objId,$remoteID,\"Resources\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_Study_Resource SET StudyVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', ResourceVar="{$remoteVar}" ')." WHERE StudyID=$this->objId AND ResourceID=$remoteID LIMIT 1 ";
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
				$q = "DELETE FROM xr_BiomarkerStudyData_Study WHERE StudyID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerStudyDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND StudyVar = \"Biomarkers\" ";
				break;
			case "BiomarkerOrganDatas":
				$q = "DELETE FROM xr_BiomarkerOrganStudyData_Study WHERE StudyID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerOrganStudyDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND StudyVar = \"BiomarkerOrganDatas\" ";
				break;
			case "BiomarkerOrgans":
				$q = "DELETE FROM xr_Study_BiomarkerOrganData WHERE StudyID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerOrganDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND StudyVar = \"BiomarkerOrgans\" ";
				break;
			case "Publications":
				$q = "DELETE FROM xr_Study_Publication WHERE StudyID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND PublicationID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND StudyVar = \"Publications\" ";
				break;
			case "Resources":
				$q = "DELETE FROM xr_Study_Resource WHERE StudyID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND ResourceID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND StudyVar = \"Resources\" ";
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